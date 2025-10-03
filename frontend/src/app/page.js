import {Header} from "@/components/Header";

export default function Home() {

    return (
        <div data-theme="mytheme">
            <Header/>
            {Array.from({length: 100}, (_, i) => (
                <div key={i}>Item {i + 1}</div>
            ))}
            <select>
                {Array.from({length: 100}, (_, i) => (
                    <option key={i}>Item {i + 1}</option>
                ))}
            </select>
            <Header/>
        </div>
    );
}
