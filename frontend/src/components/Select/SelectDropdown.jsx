"use client";
import React from "react";
import { Virtuoso } from "react-virtuoso";
import SelectDropdownItem from "./SelectDropdownItem";

export default function SelectDropdown({
  isOpen,
  placement,
  dropdownRef,
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
  loadMoreItems,
}) {
  if (!isOpen) return null;

  const MAX_HEIGHT_REM = 15; // altura máxima desejada (~240px)
  const EST_ITEM_HEIGHT_REM = 2.5; // estimativa da altura de um item (~40px)
  const VIRTUALIZE_THRESHOLD = Math.floor(MAX_HEIGHT_REM / EST_ITEM_HEIGHT_REM); // ~6 itens
  const shouldVirtualize = items.length > VIRTUALIZE_THRESHOLD;

  // Helper to render one option consistently
  const renderOption = (opt, index) => (
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
  );

  // Reusable Skeletons block
  const Skeletons = () => (
    <>
      {Array.from({ length: loadingSkeletonCount }).map((_, idx) => (
        <div key={`skeleton-${idx}`} className="skeleton h-8 my-1" />
      ))}
    </>
  );

  return (
    <div
      ref={dropdownRef}
      className={`absolute w-full ${
        placement === "top" ? "mb-1 bottom-full" : "mt-1 top-full"
      } bg-base-100 border border-base-300 rounded-box shadow-xl max-h-[15rem] z-50 overflow-auto`}
      style={shouldVirtualize ? { height: "15rem" } : undefined}
    >
      {!loading && items.length === 0 && (
        <div className="px-3 py-2 text-base-content/60">{noResultsMessage}</div>
      )}

      {shouldVirtualize ? (
        <Virtuoso
          data={items}
          endReached={loadMoreItems}
          itemContent={(index, opt) => renderOption(opt, index)}
          components={{
            Footer: () => (loading ? <Skeletons /> : null),
          }}
        />
      ) : (
        <div>
          {items.map((opt, index) => renderOption(opt, index))}
          {loading && <Skeletons />}
        </div>
      )}
    </div>
  );
}
