"use client";
import React, {useState, useEffect, useRef, Suspense, memo} from "react";
import {GET} from '@/app/api/search/route'
import getByPath from "@/utils/getByPath";

const SelectDropdownList = memo(({option, onClick, highlight, renderItem, labelField}) => {
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

    const [optionsRef, setOptionRef] = useState([]); // mantém todos os itens
    const dropdownRef = useRef(null);
    const inputRef = useRef(null);
    const containerRef = useRef(null);

    const [placement, setPlacement] = useState('bottom');

    // Debounce search
    useEffect(() => {
        const handler = setTimeout(() => setDebouncedQuery(query), 300);
        return () => clearTimeout(handler);
    }, [query]);

    // Fetch options quando query muda
    useEffect(() => {
        setPage(1);
        if (isOpen) {
            fetchOptions(debouncedQuery, 1, true)
        }
        ;
    }, [debouncedQuery, JSON.stringify(extraParams), isOpen]);

    const fetchOptions = async (search, pg = 1, reset = false) => {

        setLoading(true);

        try {
            const data = await GET({
                apiUrl, page, search, ...extraParams
            })

            const newOptions = dataField.split(".").reduce((acc, key) => acc[key], data) || [];

            if (reset) {
                setOptionRef(newOptions ?? [])
                if (dropdownRef.current) dropdownRef.current.scrollTop = 0;
            } else {
                // Salvar scroll atual
                const scrollTop = dropdownRef.current?.scrollTop ?? 0;
                const scrollHeightBefore = dropdownRef.current?.scrollHeight ?? 0;

                setOptionRef(prev => [...prev, ...newOptions]);

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
        const {scrollTop, scrollHeight, clientHeight} = e.target;

        if (!hasMore || loading) return;

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
                    if (onSelect !== undefined) {
                        onSelect(newSelected);
                    }
                }
            }
        } else {
            const newSelected = [option];
            setSelected(newSelected);
            if (onSelect !== undefined) {
                onSelect(option);
            }
            setIsOpen(false);
        }
        setQuery("");
        if (inputRef.current) {
            // Return focus to the input after selecting an item (click or keyboard)
            inputRef.current.focus({ preventScroll: true });
        }
    };

    const removeSelection = (value) => {
        const newSelected = selected.filter((s) => getByPath(s, valueField) !== value);
        setSelected(newSelected);
        if (onSelect !== undefined) {
            onSelect(multiple ? newSelected : null);
        }
    };

    const clearAll = () => {
        setSelected([]);
        if (onSelect !== undefined) {
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

        // Clear selection on Backspace for single-select when optional and input is empty
        if (
            e.key === "Backspace" &&
            !multiple &&
            !required &&
            (!query || query.length === 0) &&
            selected.length > 0
        ) {
            setSelected([]);
            if (onSelect !== undefined) {
                onSelect(null);
            }
            e.preventDefault();
            return;
        }

        if (e.key === "ArrowDown") {
            e.preventDefault();
            setHighlightIndex((i) => Math.min(i + 1, optionsRef.length - 1));
        }
        if (e.key === "ArrowUp") {
            e.preventDefault();
            setHighlightIndex((i) => Math.max(i - 1, 0));
        }
        if (e.key === "Enter" && highlightIndex >= 0) {
            e.preventDefault();
            handleSelect(optionsRef[highlightIndex]);
        }
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
        : {all: optionsRef.current};

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

    // Decide dropdown placement (top/bottom) similar to native select
    useEffect(() => {
        if (!isOpen) return;
        const computePlacement = () => {
            if (!containerRef.current) return;
            const rect = containerRef.current.getBoundingClientRect();
            const viewportH = window.innerHeight || document.documentElement.clientHeight;
            const spaceBelow = viewportH - rect.bottom;
            const spaceAbove = rect.top;
            const desired = 240; // ~max-h-60 (15rem)
            const nextPlacement = spaceBelow < desired && spaceAbove > spaceBelow ? 'top' : 'bottom';
            setPlacement(nextPlacement);
        };
        computePlacement();
        const onWinChange = () => computePlacement();
        window.addEventListener('resize', onWinChange);
        window.addEventListener('scroll', onWinChange, true);
        return () => {
            window.removeEventListener('resize', onWinChange);
            window.removeEventListener('scroll', onWinChange, true);
        };
    }, [isOpen]);

    // Ensure highlighted item stays in view when navigating with arrow keys
    useEffect(() => {
        if (!isOpen || highlightIndex < 0) return;
        const parent = dropdownRef.current;
        if (!parent) return;
        const el = parent.querySelector(`[data-index="${highlightIndex}"]`);
        if (!el) return;
        const elTop = el.offsetTop;
        const elBottom = elTop + el.offsetHeight;
        const viewTop = parent.scrollTop;
        const viewBottom = viewTop + parent.clientHeight;
        if (elTop < viewTop) {
            parent.scrollTop = elTop;
        } else if (elBottom > viewBottom) {
            parent.scrollTop = elBottom - parent.clientHeight;
        }
    }, [highlightIndex, isOpen, optionsRef]);

    return (
        <div className="relative font-sans" ref={containerRef}>
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
                    className={`absolute w-full ${placement === 'top' ? 'mb-1 bottom-full' : 'mt-1 top-full'} bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded shadow-lg max-h-60 overflow-y-auto z-50`}
                >
                    {!loading && optionsRef.length === 0 && (
                        <div className="px-3 py-2 text-gray-500 dark:text-gray-400">{noResultsMessage}</div>
                    )}

                    {optionsRef.map((group, index) => (
                        <div key={getByPath(group, valueField) ?? index} data-index={index}>
                            {groupField && (
                                <div className="px-3 py-1 font-semibold bg-gray-100 dark:bg-gray-700">{group}</div>
                            )}
                            <Suspense fallback={<span />}>
                                <SelectDropdownList
                                    option={group}
                                    onClick={handleSelect}
                                    highlight={highlightIndex === index}
                                    renderItem={renderItem}
                                    labelField={labelField}
                                />
                            </Suspense>
                        </div>
                    ))}

                    {loading && Array.from({length: loadingSkeletonCount}).map((_, idx) => (
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
