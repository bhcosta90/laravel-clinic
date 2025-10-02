"use client";
import Select from "@/components/Select";

export default function Home() {

    return (
    <div>
        testing
        <Select
            apiUrl="http://127.0.0.1:8600/api/v1/procedures?fields=uuid name"
            onSelect={() => {}}
            labelField='data.name'
            valueField='data.uuid'
            //renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
        />
    </div>
  );
}
