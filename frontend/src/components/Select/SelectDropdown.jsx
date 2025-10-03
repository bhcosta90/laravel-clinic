"use client";
import React from "react";
import SelectDropdownItem from "./SelectDropdownItem";

export default function SelectDropdown({
  isOpen,
  placement,
  dropdownRef,
  handleScroll,
  items,
  loading,
  loadingSkeletonCount,
  itemClasses,
  onSelect,
  highlightIndex,
  isSelected,
  renderItem,
  labelField,
  noResultsMessage = "Nenhum resultado",
}) {
  if (!isOpen) return null;

  return (
    <div
      ref={dropdownRef}
      onScroll={handleScroll}
      className={`absolute w-full ${placement === 'top' ? 'mb-1 bottom-full' : 'mt-1 top-full'} bg-base-100 border border-base-300 rounded-box shadow-xl max-h-60 overflow-y-auto z-50`}
    >
      {!loading && items.length === 0 && (
        <div className="px-3 py-2 text-base-content/60">Nenhum resultado</div>
      )}

      {items.map((opt, index) => (
        <SelectDropdownItem
          key={index}
          option={opt}
          index={index}
          onClick={onSelect}
          highlighted={highlightIndex === index}
          selected={isSelected(opt)}
          renderItem={renderItem}
          labelField={labelField}
          classes={itemClasses}
        />
      ))}

      {loading && Array.from({length: loadingSkeletonCount}).map((_, idx) => (
        <div key={`skeleton-${idx}`} className="skeleton h-8 my-1" />
      ))}
    </div>
  );
}
