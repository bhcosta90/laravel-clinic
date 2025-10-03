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
  disabled = false,
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
    disabled,
  });

  // Notify parent on selection changes
  useEffect(() => {
    if (onSelect === undefined) return;
    if (multiple) onSelect(selected);
    else onSelect(selected[0] ?? null);
  }, [selected, multiple, onSelect]);

  const isSelected = (opt) => selected.some((s) => getByPath(s, valueField) === getByPath(opt, valueField));

  return (
    <div className="relative form-control w-full" ref={containerRef} aria-disabled={disabled}>
      <div className={`w-full input input-bordered ${disabled ? 'input-disabled cursor-not-allowed' : ''} ${sz.inputSize} flex flex-wrap ${(multiple && selected.length > 1) ? 'items-start h-auto py-2' : 'items-center'} ${sz.containerGap} ${sz.text} bg-base-100`}>
        <SelectChips
          selected={selected}
          valueField={valueField}
          labelField={labelField}
          multiple={multiple}
          required={required}
          disabled={disabled}
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
          disabled={disabled}
          readOnly={disabled}
          tabIndex={disabled ? -1 : 0}
          onFocus={disabled ? undefined : () => setIsOpen(true)}
          onChange={disabled ? undefined : (e) => setQuery(e.target.value)}
          onKeyDown={disabled ? undefined : handleKeyDown}
          className={`flex-1 min-w-[1ch] bg-transparent px-1 py-0 outline-none border-0 focus:outline-none ${(multiple && selected.length > 1) ? 'self-start' : 'self-center'}`}
        />

        {!disabled && !multiple && !required && selected.length > 0 && (
          <button
            type="button"
            aria-label="Limpar seleção"
            onClick={(e) => {
              e.stopPropagation();
              clearAll();
              if (inputRef.current) inputRef.current.focus({ preventScroll: true });
            }}
            className={`cursor-pointer`}
          >
              <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  className="w-3 h-3"
                  aria-hidden="true"
              >
                  <path
                      fillRule="evenodd"
                      d="M6.225 6.225a.75.75 0 0 1 1.06 0L12 10.94l4.715-4.715a.75.75 0 1 1 1.06 1.06L13.06 12l4.715 4.715a.75.75 0 1 1-1.06 1.06L12 13.06l-4.715 4.715a.75.75 0 1 1-1.06-1.06L10.94 12l-4.715-4.715a.75.75 0 0 1 0-1.06z"
                      clipRule="evenodd"
                  />
              </svg>
          </button>
        )}

        {/* Dropdown chevron indicator at the far right, after the clear X when present */}
        <button
          type="button"
          aria-label={isOpen ? 'Fechar opções' : 'Abrir opções'}
          onClick={(e) => {
            if (disabled) return;
            e.stopPropagation();
            setIsOpen((prev) => !prev);
            if (inputRef.current) inputRef.current.focus({ preventScroll: true });
          }}
          disabled={disabled}
          className={`${disabled ? '' : 'cursor-pointer'}`}
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            className="w-4 h-4"
          >
            <path fillRule="evenodd" d="M12 15a1 1 0 0 1-.707-.293l-5-5a 1 1 0 1 1 1.414-1.414L12 12.586l4.293-4.293a1 1 0 0 1 1.414 1.414l-5 5A1 1 0 0 1 12 15z" clipRule="evenodd" />
          </svg>
        </button>
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
