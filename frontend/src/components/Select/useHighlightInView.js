"use client";
import {useEffect} from "react";

export default function useHighlightInView({isOpen, highlightIndex, dropdownRef, items}) {
  useEffect(() => {
    if (!isOpen || highlightIndex < 0) return;
    const parent = dropdownRef.current;
    if (!parent) return;
    const el = parent.querySelector(`[data-index="${highlightIndex}"]`);
    if (!el) return;
    const elTop = el.offsetTop;
    const elBottom = elTop + el.offsetHeight;
    const viewTop = parent.scrollTop;
    const viewBottom = viewTop + parent.clientHeight;
    if (elTop < viewTop) parent.scrollTop = elTop;
    else if (elBottom > viewBottom) parent.scrollTop = elBottom - parent.clientHeight;
  }, [isOpen, highlightIndex, dropdownRef, items]);
}
