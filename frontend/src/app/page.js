"use client";
import Image from "next/image";
import Select from "@/components/Select";
import {useState} from "react";

export default function Home() {
    const [selectedCategory, setSelectedCategory] = useState(null);

    return (
    <div>
        <Select
            apiUrl="http://127.0.0.1:8600/api/v1/procedures?fields=uuid name"
            onSelect={() => {}}
            labelField='data.name'
            //renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
        />
    </div>
  );
}
