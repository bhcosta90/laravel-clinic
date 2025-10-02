"use client";
import Select from "@/components/Select";
import {Header} from "@/components/Header";

export default function Home() {

    return (
    <div>
        <Header/>
        <Select
            apiUrl="procedures?fields=uuid name"
            onSelect={() => {}}
            labelField='data.name'
            valueField='data.uuid'
            //renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
        />
    </div>
  );
}
