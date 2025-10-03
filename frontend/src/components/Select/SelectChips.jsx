"use client";
import React from "react";
import getByPath from "@/utils/getByPath";

export default function SelectChips({
  selected,
  valueField,
  labelField,
  multiple,
  required,
  sz,
  renderItem,
  onRemove,
  onClearAll,
}) {
  return (
    <>
      {selected.map((item) => {
        const value = getByPath(item, valueField);
        const key = value ?? getByPath(item, labelField);
        const canDeleted = (required && !multiple) || (multiple && required && selected.length === 1);
        return (
          <span
            key={`selected-${key}`}
            className={`badge ${sz.chipSize} badge-outline badge-primary gap-1 items-center${!canDeleted ? " cursor-pointer" : ""}`}
            onClick={(e) => {
              if (canDeleted) return;
              e.stopPropagation();
              onRemove(value);
            }}
          >
            {renderItem ? renderItem(item) : getByPath(item, labelField)}
            {multiple && !canDeleted && (
              <button
                type="button"
                onClick={(e) => {
                  e.stopPropagation();
                  onRemove(value);
                }}
                className={`btn btn-ghost ${sz.btnSize} btn-circle ml-1`}
              >
                ×
              </button>
            )}
          </span>
        );
      })}

    </>
  );
}
