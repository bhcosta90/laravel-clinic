"use client";
import {useEffect, useState} from "react";

export default function usePlacement(isOpen, containerRef) {
  const [placement, setPlacement] = useState('bottom');
  useEffect(() => {
    if (!isOpen) return;
    const computePlacement = () => {
      if (!containerRef.current) return;
      const rect = containerRef.current.getBoundingClientRect();
      const viewportH = window.innerHeight || document.documentElement.clientHeight;
      const spaceBelow = viewportH - rect.bottom;
      const spaceAbove = rect.top;
      const desired = 240;
      const nextPlacement = spaceBelow < desired && spaceAbove > spaceBelow ? 'top' : 'bottom';
      setPlacement(nextPlacement);
    };
    computePlacement();
    const onWinChange = () => computePlacement();
    window.addEventListener('resize', onWinChange);
    window.addEventListener('scroll', onWinChange, true);
    return () => {
      window.removeEventListener('resize', onWinChange);
      window.removeEventListener('scroll', onWinChange, true);
    };
  }, [isOpen, containerRef]);
  return placement;
}
