"use client";
import React from "react";
import getByPath from "@/utils/getByPath";

export default function SelectChips({
  selected,
  valueField,
  labelField,
  multiple,
  required,
  disabled = false,
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
        const canDeleted = disabled || (required && !multiple) || (multiple && required && selected.length === 1);
        return (
          <span
            key={`selected-${key}`}
            className={`badge ${sz.chipSize} badge-outline badge-primary gap-1 items-center${!canDeleted ? " cursor-pointer" : ""} ${disabled ? 'opacity-60' : ''}`}
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
          </span>
        );
      })}

    </>
  );
}
