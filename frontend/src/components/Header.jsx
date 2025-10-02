"use client";
import {useState} from "react";
import Select from "@/components/Select/Index";

export const Header = () => {
    return <div>
        <Select
            apiUrl="procedures?fields=uuid name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
            labelField='data.name'
            valueField='data.uuid'
        />
    </div>
}