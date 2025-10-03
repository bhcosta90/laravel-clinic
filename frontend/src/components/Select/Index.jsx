"use client";
import React, {useEffect} from "react";
import getByPath from "@/utils/getByPath";
import useSelectLogic from "./useSelectLogic";
import {getSize} from "./selectSizes";
import SelectChips from "./SelectChips";
import SelectDropdown from "./SelectDropdown";

const Select = ({
  apiUrl,
  labelField,
  valueField,
  onSelect = undefined,
  extraParams = {},
  required = false,
  placeholder = "Buscar...",
  dataField = "data",
  hasMoreField = "meta.has_more_pages",
  renderItem,
  multiple = false,
  maxSelection = Infinity,
  loadingSkeletonCount = 5,
  noResultsMessage = "Nenhum resultado",
  initialValues = [],
  size = 'md',
  options = null,
  pageSize = 50,
}) => {
  const sz = getSize(size);

  const {
    // state
    query, setQuery,
    selected, setSelected,
    loading, hasMore, highlightIndex, setHighlightIndex,
    isOpen, setIsOpen,
    items,
    // refs
    dropdownRef, inputRef, containerRef,
    // config
    placement,
    // handlers
    handleScroll, handleKeyDown, onSelectInternal, removeSelection, clearAll,
  } = useSelectLogic({
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
    initialSelected: initialValues,
    maxSelection,
  });

  // Notify parent on selection changes
  useEffect(() => {
    if (onSelect === undefined) return;
    if (multiple) onSelect(selected);
    else onSelect(selected[0] ?? null);
  }, [selected, multiple, onSelect]);

  const isSelected = (opt) => selected.some((s) => getByPath(s, valueField) === getByPath(opt, valueField));

  return (
    <div className="relative form-control w-full" ref={containerRef}>
      <div className={`w-full input input-bordered ${sz.inputSize} flex flex-wrap ${multiple ? 'items-start h-auto py-2' : 'items-center'} ${sz.containerGap} ${sz.text} bg-base-100`}>
        <SelectChips
          selected={selected}
          valueField={valueField}
          labelField={labelField}
          multiple={multiple}
          required={required}
          sz={sz}
          renderItem={renderItem}
          onRemove={(val) => removeSelection(val)}
          onClearAll={() => clearAll()}
        />

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

      <SelectDropdown
        isOpen={isOpen}
        placement={placement}
        dropdownRef={dropdownRef}
        handleScroll={handleScroll}
        items={items}
        loading={loading}
        loadingSkeletonCount={loadingSkeletonCount}
        itemClasses={`${sz.itemPadding} ${sz.itemText}`}
        onSelect={onSelectInternal}
        highlightIndex={highlightIndex}
        isSelected={isSelected}
        renderItem={renderItem}
        labelField={labelField}
        noResultsMessage={noResultsMessage}
        hasMore={hasMore}
      />
    </div>
  );
};

export default Select;
