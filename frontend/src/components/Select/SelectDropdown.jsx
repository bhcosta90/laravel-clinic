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
                                           loadMoreItems
                                       }) {
    if (!isOpen) return null;

    return (
        <div
            ref={dropdownRef}
            className={`absolute w-full ${
                placement === "top" ? "mb-1 bottom-full" : "mt-1 top-full"
            } bg-base-100 border border-base-300 rounded-box shadow-xl max-h-60 z-50`}
            style={{ height: "15rem" }} // mesma altura do max-h-60 (≈240px)
        >
            {!loading && items.length === 0 && (
                <div className="px-3 py-2 text-base-content/60">{noResultsMessage}</div>
            )}

            <Virtuoso
                data={items}
                endReached={loadMoreItems}
                itemContent={(index, opt) => (
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
                )}
                components={{
                    Footer: () =>
                        loading ? (
                            <>
                                {Array.from({ length: loadingSkeletonCount }).map((_, idx) => (
                                    <div
                                        key={`skeleton-${idx}`}
                                        className="skeleton h-8 my-1"
                                    />
                                ))}
                            </>
                        ) : null,
                }}
            />
        </div>
    );
}
