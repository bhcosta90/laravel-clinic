import Select from "@/components/Select";
import {Header} from "@/components/Header";

export default function Home() {

    return (
    <div>
        <Header/>
        <Select
            apiUrl="procedures?fields=uuid name"
            // onSelect={() => {}}
            // renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
            labelField='data.name'
            valueField='data.uuid'
            multiple
        />
    </div>
  );
}
