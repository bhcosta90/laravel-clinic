"use client";
import React, {memo} from "react";
import getByPath from "@/utils/getByPath";

const SelectDropdownItem = memo(function SelectDropdownItem({
  option,
  index,
  onClick,
  highlighted,
  selected,
  renderItem,
  labelField,
  classes,
}) {
  const stateClass = highlighted
    ? "bg-primary/10 text-primary"
    : selected
      ? "bg-primary/5 text-primary"
      : "hover:bg-base-200";

  return (
    <div
      data-index={index}
      onClick={() => onClick(option)}
      className={`${classes} cursor-pointer border-b border-base-200 last:border-b-0 ${stateClass}`}
    >
      {renderItem ? renderItem(option) : getByPath(option, labelField)}
    </div>
  );
});

export default SelectDropdownItem;
