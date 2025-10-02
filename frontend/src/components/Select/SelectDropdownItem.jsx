import React, {memo} from "react";
import getByPath from "@/utils/getByPath";

export const SelectDropdownList = memo(({option, onClick, highlight, renderItem, labelField}) => {
    return <div
        onClick={() => onClick(option)}
        className={`px-3 py-2 cursor-pointer border-b border-gray-100 dark:border-gray-700 ${
            highlight ? "bg-blue-100 dark:bg-blue-600" : "hover:bg-blue-50 dark:hover:bg-blue-500/20"
        }`}
    >
        {renderItem ? renderItem(option) : getByPath(option, labelField)}
    </div>
});

export default SelectDropdownList;