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
      const idx = typeof items?.length === 'number' ? Math.max(0, Math.min(items.length - 1, typeof e?.currentTarget?.dataset?.index === 'number' ? e.currentTarget.dataset.index : 0)) : -1;
      if (idx >= 0) onSelect(items[idx]);
    }
    if (e.key === "Escape") setIsOpen(false);
  };
}
