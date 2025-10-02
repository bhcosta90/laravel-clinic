"use client";
import React, { useState, useEffect, useRef, memo } from "react";
import { GET } from '@/app/api/search/route'
import axios from "axios";

// Helper to safely resolve nested fields like "data.name"
const getByPath = (obj, path) => {
    if (!obj || !path) return undefined;
    if (typeof path !== "string") return obj[path];
    if (path.indexOf(".") === -1) return obj[path];
    return path.split(".").reduce((acc, key) => (acc != null ? acc[key] : undefined), obj);
};

const DropdownItem = memo(({ option, onClick, highlight, renderItem, labelField }) => {
    return <div
        onClick={() => onClick(option)}
        className={`px-3 py-2 cursor-pointer border-b border-gray-100 dark:border-gray-700 ${
            highlight ? "bg-blue-100 dark:bg-blue-600" : "hover:bg-blue-50 dark:hover:bg-blue-500/20"
        }`}
    >
        {renderItem ? renderItem(option) : getByPath(option, labelField)}
    </div>
});

const Select = ({
        apiUrl,
        onSelect,
        extraParams = {},
        labelField = "name",
        valueField = "id",
        required = false,
        placeholder = "Buscar...",
        dataField = "data",
        hasMoreField = "meta.has_more_pages",
        renderItem,
        multiple = false,
        maxSelection = Infinity,
        groupField,
        loadingSkeletonCount = 5,
        noResultsMessage = "Nenhum resultado",
        highlightSearch = true,
        initialValues = [],
    }) => {
    const [query, setQuery] = useState("");
    const [debouncedQuery, setDebouncedQuery] = useState("");
    const [selected, setSelected] = useState(initialValues);
    const [loading, setLoading] = useState(false);
    const [page, setPage] = useState(1);
    const [hasMore, setHasMore] = useState(true);
    const [highlightIndex, setHighlightIndex] = useState(-1);
    const [isOpen, setIsOpen] = useState(false);

    const optionsRef = useRef([]); // mantém todos os itens
    const dropdownRef = useRef(null);
    const inputRef = useRef(null);

    // Debounce search
    useEffect(() => {
        const handler = setTimeout(() => setDebouncedQuery(query), 300);
        return () => clearTimeout(handler);
    }, [query]);

    // Fetch options quando query muda
    useEffect(() => {
        if (isOpen) fetchOptions(debouncedQuery, 1, true);
    }, [debouncedQuery, JSON.stringify(extraParams), isOpen]);

    const fetchOptions = async (q, pg = 1, reset = false) => {

        setLoading(true);

        try {
            const data = await GET({
                apiUrl, page, q, ...extraParams
            })

            const newOptions = dataField.split(".").reduce((acc, key) => acc[key], data) || [];

            if (reset) {
                optionsRef.current = newOptions;
                if (dropdownRef.current) dropdownRef.current.scrollTop = 0;
            } else {
                // Salvar scroll atual
                const scrollTop = dropdownRef.current?.scrollTop ?? 0;
                const scrollHeightBefore = dropdownRef.current?.scrollHeight ?? 0;

                optionsRef.current.push(...newOptions);

                // Restaurar scroll proporcional
                if (dropdownRef.current) {
                    const scrollHeightAfter = dropdownRef.current.scrollHeight;
                    dropdownRef.current.scrollTop = scrollTop + (scrollHeightAfter - scrollHeightBefore);
                }
            }

            const more = hasMoreField.split(".").reduce((acc, key) => acc[key], data) ?? false;
            setHasMore(more);
            setPage(pg + 1);
        } catch (err) {
            console.error(err);
        } finally {
            setLoading(false);
        }
    };

    const handleScroll = async (e) => {
        const { scrollTop, scrollHeight, clientHeight } = e.target;

        if(!hasMore || loading) return;

        if (scrollTop + clientHeight >= scrollHeight - 10) {
            await fetchOptions(debouncedQuery, page);
        }
    };

    const handleSelect = (option) => {
        if (multiple) {
            if (!selected.some((s) => getByPath(s, valueField) === getByPath(option, valueField))) {
                if (selected.length < maxSelection) {
                    const newSelected = [...selected, option];
                    setSelected(newSelected);
                    if(onSelect !== undefined){
                        onSelect(newSelected);
                    }
                }
            }
        } else {
            const newSelected = [option];
            setSelected(newSelected);
            if(onSelect !== undefined) {
                onSelect(option);
            }
            setIsOpen(false);
        }
        setQuery("");
    };

    const removeSelection = (value) => {
        const newSelected = selected.filter((s) => getByPath(s, valueField) !== value);
        setSelected(newSelected);
        if(onSelect !== undefined) {
            onSelect(multiple ? newSelected : null);
        }
    };

    const clearAll = () => {
        setSelected([]);
        if(onSelect !== undefined) {
            onSelect(multiple ? [] : null);
        }
    };

    const handleKeyDown = (e) => {
        // Remove last selected on Backspace when multiple and input is empty
        if (
            e.key === "Backspace" &&
            multiple &&
            (!query || query.length === 0) &&
            selected.length > 0
        ) {
            const newSelected = selected.slice(0, -1);
            setSelected(newSelected);
            if (onSelect !== undefined) {
                onSelect(newSelected);
            }
            e.preventDefault(); // avoid navigating back in some environments
            return;
        }

        if (e.key === "ArrowDown") setHighlightIndex((i) => Math.min(i + 1, optionsRef.current.length - 1));
        if (e.key === "ArrowUp") setHighlightIndex((i) => Math.max(i - 1, 0));
        if (e.key === "Enter" && highlightIndex >= 0) handleSelect(optionsRef.current[highlightIndex]);
        if (e.key === "Escape") setIsOpen(false);
    };

    const highlightText = (text) => {
        if (!highlightSearch || !debouncedQuery) return text;
        const regex = new RegExp(`(${debouncedQuery})`, "gi");
        return text.split(regex).map((part, idx) =>
            regex.test(part) ? <mark key={idx} className="bg-yellow-200 dark:bg-yellow-600">{part}</mark> : part
        );
    };

    const groupedOptions = groupField
        ? optionsRef.current.reduce((acc, item) => {
            const group = item[groupField] || "Outros";
            if (!acc[group]) acc[group] = [];
            acc[group].push(item);
            return acc;
        }, {})
        : { all: optionsRef.current };

    // Fecha ao clicar fora
    useEffect(() => {
        const handleClickOutside = (event) => {
            if (
                dropdownRef.current &&
                !dropdownRef.current.contains(event.target) &&
                inputRef.current &&
                !inputRef.current.contains(event.target)
            ) {
                setIsOpen(false);
                setHighlightIndex(-1);
            }
        };
        document.addEventListener("mousedown", handleClickOutside);
        return () => document.removeEventListener("mousedown", handleClickOutside);
    }, []);

    return (
        <div className="relative font-sans">
            <div className="flex flex-wrap items-center gap-1 border rounded px-2 py-1 bg-white dark:bg-gray-800">
                {selected.map((item) => (
                    <span
                        key={getByPath(item, valueField) ? `selected-${getByPath(item, valueField)}` : `selected-${getByPath(item, labelField)}`}
                        className="flex items-center bg-blue-100 dark:bg-blue-600 text-blue-800 dark:text-white px-2 py-0.5 rounded-full text-sm"
                    >
                        {renderItem ? renderItem(item) : getByPath(item, labelField)}
                        <button
                            type="button"
                            onClick={(e) => {
                                e.stopPropagation();
                                removeSelection(getByPath(item, valueField));
                            }}
                            className="ml-1 text-gray-500 dark:text-gray-200 hover:text-gray-800 dark:hover:text-white focus:outline-none"
                        >
              ×
            </button>
          </span>
                ))}
                <input
                    ref={inputRef}
                    type="text"
                    placeholder={selected.length ? "" : placeholder}
                    value={query}
                    onFocus={() => setIsOpen(true)}
                    onChange={(e) => setQuery(e.target.value)}
                    onKeyDown={handleKeyDown}
                    className="flex-1 min-w-[50px] outline-none bg-transparent px-1 py-1 text-sm text-gray-900 dark:text-white"
                />
                {!required && selected.length > 0 && (
                    <button
                        onClick={(e) => {
                            e.stopPropagation();
                            clearAll();
                        }}
                        className="ml-1 text-gray-500 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none"
                    >
                        ×
                    </button>
                )}
            </div>

            {isOpen && (
                <div
                    ref={dropdownRef}
                    onScroll={handleScroll}
                    className="absolute w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded shadow-lg max-h-60 overflow-y-auto z-50"
                >
                    {!loading && Object.keys(groupedOptions).length === 0 && (
                        <div className="px-3 py-2 text-gray-500 dark:text-gray-400">{noResultsMessage}</div>
                    )}

                    {Object.entries(groupedOptions).map(([group, items]) => (
                        <div key={group}>
                            {groupField && (
                                <div className="px-3 py-1 font-semibold bg-gray-100 dark:bg-gray-700">{group}</div>
                            )}
                            {items.map((option, idx) => (
                                <DropdownItem
                                    key={getByPath(option, valueField) ? `option-${getByPath(option, valueField)}` : `option-${group}-${idx}`}
                                    option={option}
                                    onClick={handleSelect}
                                    highlight={highlightIndex === idx}
                                    renderItem={renderItem}
                                    labelField={labelField}
                                />
                            ))}
                        </div>
                    ))}

                    {loading && Array.from({ length: loadingSkeletonCount }).map((_, idx) => (
                        <div
                            key={`skeleton-${idx}`}
                            className="h-8 bg-gray-200 dark:bg-gray-700 animate-pulse my-1 rounded"
                        />
                    ))}
                </div>
            )}
        </div>
    );
};

export default Select;
