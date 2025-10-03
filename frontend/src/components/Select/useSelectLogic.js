"use client";
import {useEffect, useMemo, useRef, useState} from "react";
import {GET} from '@/app/api/search/route';
import getByPath from "@/utils/getByPath";
import readField from "./readField";
import usePlacement from "./usePlacement";
import useOutsideClickClose from "./useOutsideClickClose";
import useHighlightInView from "./useHighlightInView";
import useKeyboardNav from "./useKeyboardNav";

export default function useSelectLogic({
  apiUrl,
  options,
  pageSize,
  dataField,
  hasMoreField,
  extraParams,
  multiple,
  required,
  valueField,
  labelField,
  loadingSkeletonCount,
  initialSelected = [],
  maxSelection = Infinity,
  disabled = false,
}) {
  const [query, setQuery] = useState("");
  const [debouncedQuery, setDebouncedQuery] = useState("");
  const [selected, setSelected] = useState(initialSelected);
  const [loading, setLoading] = useState(false);
  const [page, setPage] = useState(1);
  const [hasMore, setHasMore] = useState(true);
  const [highlightIndex, setHighlightIndex] = useState(-1);
  const [isOpen, setIsOpen] = useState(false);

  const [items, setItems] = useState([]);
  const [localFiltered, setLocalFiltered] = useState([]);

  const dropdownRef = useRef(null);
  const inputRef = useRef(null);
  const containerRef = useRef(null);

  const placement = usePlacement(isOpen, containerRef);
  useOutsideClickClose({
    dropdownRef,
    inputRef,
    onClose: () => {
      setIsOpen(false);
      setHighlightIndex(-1);
    }
  });

  // Close if becomes disabled
  useEffect(() => {
    if (disabled) {
      setIsOpen(false);
      setHighlightIndex(-1);
    }
  }, [disabled]);
  useHighlightInView({ isOpen, highlightIndex, dropdownRef, items });

  const isLocal = useMemo(() => !apiUrl && Array.isArray(options), [apiUrl, options]);

  // Debounce search
  useEffect(() => {
    const h = setTimeout(() => setDebouncedQuery(query), 300);
    return () => clearTimeout(h);
  }, [query]);

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
      setItems(first);
      setHasMore(all.length > first.length);
      if (dropdownRef.current) dropdownRef.current.scrollTop = 0;
      setLoading(false);
    } else {
      fetchOptions(debouncedQuery, 1, true).catch(() => {});
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [debouncedQuery, JSON.stringify(extraParams), isOpen, isLocal, Array.isArray(options) ? options.length : 0, pageSize]);


  const fetchOptions = async (search, pg = 1, reset = false) => {
    setLoading(true);
    try {
      const data = await GET({ apiUrl, page: pg, search, ...extraParams });
      const newOptions = readField(data, dataField, []);

      if (reset) {
        setItems(newOptions ?? []);
        if (dropdownRef.current) dropdownRef.current.scrollTop = 0;
      } else {
        // preserve scroll position proportionally
        const scrollTop = dropdownRef.current?.scrollTop ?? 0;
        const scrollHeightBefore = dropdownRef.current?.scrollHeight ?? 0;
        setItems(prev => [...prev, ...(newOptions ?? [])]);
        if (dropdownRef.current) {
          const scrollHeightAfter = dropdownRef.current.scrollHeight;
          dropdownRef.current.scrollTop = scrollTop + (scrollHeightAfter - scrollHeightBefore);
        }
      }

      const more = !!readField(data, hasMoreField, false);
      setHasMore(more);
      setPage(pg + 1);
    } catch (e) {
      console.error(e);
    } finally {
      setLoading(false);
    }
  };

    const loadMoreItems = async () => {
        if (!hasMore || loading) return;

        if (isLocal) {
            const nextStart = items.length;
            const nextEnd = nextStart + pageSize;
            const nextSlice = localFiltered.slice(nextStart, nextEnd);
            if (nextSlice.length > 0) {
                setItems(prev => [...prev, ...nextSlice]);
                setHasMore(nextEnd < localFiltered.length);
            } else {
                setHasMore(false);
            }
        } else {
            await fetchOptions(debouncedQuery, page);
        }
    };

    const handleScroll = async (e) => {
        const { scrollTop, scrollHeight, clientHeight } = e.target;
        if (scrollTop + clientHeight >= scrollHeight - 10) {
            await loadMoreItems();
        }
    };

  const onSelectInternal = (option) => {
    if (disabled) return;
    if (multiple) {
      const exists = selected.some((s) => getByPath(s, valueField) === getByPath(option, valueField));
      if (!exists) {
        setSelected((prev) => (prev.length < maxSelection ? [...prev, option] : prev));
      }
    } else {
      setSelected([option]);
      setIsOpen(false);
    }
    setQuery("");
    if (inputRef.current) inputRef.current.focus({ preventScroll: true });
  };

  const handleKeyDown = useKeyboardNav({
    multiple,
    required,
    query,
    selected,
    items,
    setSelected,
    setIsOpen,
    setHighlightIndex,
    onSelect: onSelectInternal,
  });

  const removeSelection = (value) => {
    setSelected((prev) => prev.filter((s) => getByPath(s, valueField) !== value));
  };

  const clearAll = () => setSelected([]);

  return {
    // state
    query, setQuery, debouncedQuery,
    selected, setSelected,
    loading, page, hasMore, highlightIndex, setHighlightIndex,
    isOpen, setIsOpen,
    items, setItems,
    localFiltered,
    // refs
    dropdownRef, inputRef, containerRef,
    // config misc
    placement,
    // handlers
    handleScroll, handleKeyDown, onSelectInternal, removeSelection, clearAll, loadMoreItems,
    // data loaders
    fetchOptions,
    // consts
    loadingSkeletonCount,
  };
}
