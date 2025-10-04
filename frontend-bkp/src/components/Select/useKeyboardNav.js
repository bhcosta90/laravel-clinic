"use client";

export default function useKeyboardNav({
  multiple,
  required,
  query,
  selected,
  items,
  setSelected,
  setIsOpen,
  setHighlightIndex,
  onSelect,
  highlightIndex,
  onCreate,
}) {
  return function handleKeyDown(e) {
    if (
      e.key === "Backspace" && multiple && (!query || query.length === 0) && selected.length > 0
    ) {
      const newSelected = selected.slice(0, -1);
      setSelected(newSelected);
      e.preventDefault();
      return;
    }
    if (
      e.key === "Backspace" && !multiple && !required && (!query || query.length === 0) && selected.length > 0
    ) {
      setSelected([]);
      e.preventDefault();
      return;
    }
    if (e.key === "ArrowDown") {
      e.preventDefault();
      setHighlightIndex((i) => Math.min(i + 1, items.length - 1));
    }
    if (e.key === "ArrowUp") {
      e.preventDefault();
      setHighlightIndex((i) => Math.max(i - 1, 0));
    }
    if (e.key === "Enter") {
      e.preventDefault();
      // Prefer selecting the highlighted item when available
      const idx = typeof highlightIndex === 'number' && highlightIndex >= 0 ? highlightIndex : -1;
      if (idx >= 0 && items && items.length > 0) {
        onSelect(items[idx]);
        return;
      }
      // If no highlight and creatable is available with a non-empty query, create a new option
      if (onCreate && query && query.trim().length > 0) {
        onCreate();
        return;
      }
      // Fallback: select the first item if present
      if (items && items.length > 0) {
        onSelect(items[0]);
      }
    }
    if (e.key === "Escape") setIsOpen(false);
  };
}
