const getByPath = (obj, path) => {
    if (!obj || !path) return undefined;
    if (typeof path !== "string") return obj[path];
    if (path.indexOf(".") === -1) return obj[path];
    return path.split(".").reduce((acc, key) => (acc != null ? acc[key] : undefined), obj);
};

export default getByPath;