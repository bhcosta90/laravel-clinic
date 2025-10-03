export default function readField(obj, path, fallback = undefined) {
  if (!path) return fallback;
  try {
    return path.split('.').reduce((a, k) => a?.[k], obj) ?? fallback;
  } catch {
    return fallback;
  }
}
