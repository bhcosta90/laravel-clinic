"use client";
import React, {useState, useEffect, useRef, Suspense, memo} from "react";
import {GET} from '@/app/api/search/route'
import getByPath from "@/utils/getByPath";

const SelectDropdownList = memo(({option, onClick, highlight, selected: isSelected, renderItem, labelField, itemClasses}) => {
    const stateClass = highlight
        ? "bg-primary/10 text-primary"
        : isSelected
            ? "bg-primary/5 text-primary"
            : "hover:bg-base-200";
    return <div
        onClick={() => onClick(option)}
        className={`${itemClasses} cursor-pointer border-b border-base-200 last:border-b-0 ${stateClass}`}
    >
        {renderItem ? renderItem(option) : getByPath(option, labelField)}
    </div>
});
const Select = ({
                    apiUrl,
                    labelField,
                    valueField,
                    onSelect = null,
                    extraParams = {},
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
                    size = 'md',
                    options = null,
                    pageSize = 50,
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

    const sizeMap = {
        xs: {
            containerGap: 'gap-1',
            containerPadding: 'px-1 py-0.5',
            text: 'text-xs',
            inputSize: 'input-xs',
            chipSize: 'badge-xs',
            btnSize: 'btn-xs',
            itemPadding: 'px-2 py-1',
            itemText: 'text-xs',
        },
        sm: {
            containerGap: 'gap-1.5',
            containerPadding: 'px-2 py-1',
            text: 'text-sm',
            inputSize: 'input-sm',
            chipSize: 'badge-sm',
            btnSize: 'btn-sm',
            itemPadding: 'px-3 py-1.5',
            itemText: 'text-sm',
        },
        md: {
            containerGap: 'gap-2',
            containerPadding: 'px-2.5 py-1.5',
            text: 'text-base',
            inputSize: 'input-md',
            chipSize: 'badge-md',
            btnSize: 'btn-sm',
            itemPadding: 'px-3 py-2',
            itemText: 'text-base',
        },
        lg: {
            containerGap: 'gap-2',
            containerPadding: 'px-3 py-2',
            text: 'text-lg',
            inputSize: 'input-lg',
            chipSize: 'badge-lg',
            btnSize: 'btn-md',
            itemPadding: 'px-4 py-2.5',
            itemText: 'text-lg',
        },
        xl: {
            containerGap: 'gap-3',
            containerPadding: 'px-3.5 py-2.5',
            text: 'text-xl',
            inputSize: 'input-xl',
            chipSize: 'badge-lg',
            btnSize: 'btn-lg',
            itemPadding: 'px-4 py-3',
            itemText: 'text-lg',
        },
    };
    const sz = sizeMap[size] || sizeMap.md;

    // Debounce search
    useEffect(() => {
        const handler = setTimeout(() => setDebouncedQuery(query), 300);
        return () => clearTimeout(handler);
    }, [query]);

    const isLocal = !apiUrl && Array.isArray(options);
    const [localFiltered, setLocalFiltered] = useState([]);

    // Fetch or filter options when query changes / open toggles
    useEffect(() => {
        setPage(1);
        if (!isOpen) return;

        if (isLocal) {
            const all = (options || []).filter((opt) => {
                if (!debouncedQuery) return true;
                const label = getByPath(opt, labelField);
                return (label ?? "").toString().toLowerCase().includes(debouncedQuery.toLowerCase());
            });
            setLocalFiltered(all);
            const first = all.slice(0, pageSize);
            setOptionRef(first);
            setHasMore(all.length > first.length);
            if (dropdownRef.current) dropdownRef.current.scrollTop = 0;
            setLoading(false);
        } else {
            fetchOptions(debouncedQuery, 1, true);
        }
    }, [debouncedQuery, JSON.stringify(extraParams), isOpen, isLocal, Array.isArray(options) ? options.length : 0, pageSize]);

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
            if (isLocal) {
                const nextStart = optionsRef.length;
                const nextEnd = nextStart + pageSize;
                const nextSlice = localFiltered.slice(nextStart, nextEnd);
                if (nextSlice.length > 0) {
                    setOptionRef(prev => [...prev, ...nextSlice]);
                    setHasMore(nextEnd < localFiltered.length);
                } else {
                    setHasMore(false);
                }
            } else {
                await fetchOptions(debouncedQuery, page);
            }
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
        <div className="relative form-control w-full" ref={containerRef}>
            <div className={`w-full input input-bordered ${sz.inputSize} flex flex-wrap ${multiple ? 'items-start h-auto py-2' : 'items-center'} ${sz.containerGap} ${sz.text} bg-base-100`}>
                {selected.map((item) => {
                    const canDeleted = (required && !multiple) || (multiple && required && selected.length === 1);

                    return <span
                        key={getByPath(item, valueField) ? `selected-${getByPath(item, valueField)}` : `selected-${getByPath(item, labelField)}`}
                        className={`badge ${sz.chipSize} badge-outline badge-primary gap-1 items-center${!canDeleted ? " cursor-pointer" : ""}`}
                        onClick={(e) => {
                            if(canDeleted) return;

                            e.stopPropagation();
                            removeSelection(getByPath(item, valueField));
                        }}
                    >
                        {renderItem ? renderItem(item) : getByPath(item, labelField)}
                        {multiple && !canDeleted && (
                            <button
                                type="button"
                                onClick={(e) => {
                                    e.stopPropagation();
                                    removeSelection(getByPath(item, valueField));
                                }}
                                className={`btn btn-ghost ${sz.btnSize} btn-circle ml-1`}>
                                ×
                            </button>
                        )}
                    </span>
                })}
                <input
                    ref={inputRef}
                    type="text"
                    placeholder={selected.length ? "" : placeholder}
                    value={query}
                    onFocus={() => setIsOpen(true)}
                    onChange={(e) => setQuery(e.target.value)}
                    onKeyDown={handleKeyDown}
                    className={`flex-1 min-w-[1ch] bg-transparent px-1 py-0 outline-none border-0 focus:outline-none ${multiple ? 'self-start' : 'self-center'}`}
                />
                {!multiple && !required && selected.length > 0 && (
                    <button
                        onClick={(e) => {
                            e.stopPropagation();
                            clearAll();
                        }}
                        className={`btn btn-ghost ${sz.btnSize} btn-circle ml-1`}
                    >
                        ×
                    </button>
                )}
            </div>

            {isOpen && (
                <div
                    ref={dropdownRef}
                    onScroll={handleScroll}
                    className={`absolute w-full ${placement === 'top' ? 'mb-1 bottom-full' : 'mt-1 top-full'} bg-base-100 border border-base-300 rounded-box shadow-xl max-h-60 overflow-y-auto z-50`}
                >
                    {!loading && optionsRef.length === 0 && (
                        <div className="px-3 py-2 text-base-content/60">{noResultsMessage}</div>
                    )}

                    {optionsRef.map((group, index) => (
                        <div key={getByPath(group, valueField) ?? index} data-index={index}>
                            {groupField && (
                                <div className="px-3 py-1 font-semibold bg-base-200 text-base-content/80">{group}</div>
                            )}
                            <Suspense fallback={<span />}>
                                <SelectDropdownList
                                    option={group}
                                    onClick={handleSelect}
                                    highlight={highlightIndex === index}
                                    selected={selected.some((s) => getByPath(s, valueField) === getByPath(group, valueField))}
                                    renderItem={renderItem}
                                    labelField={labelField}
                                    itemClasses={`${sz.itemPadding} ${sz.itemText}`}
                                />
                            </Suspense>
                        </div>
                    ))}

                    {loading && Array.from({length: loadingSkeletonCount}).map((_, idx) => (
                        <div
                            key={`skeleton-${idx}`}
                            className="skeleton h-8 my-1"
                        />
                    ))}
                </div>
            )}
        </div>
    );
};

export default Select;
