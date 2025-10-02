import {useState} from "react";

export const Header = () => {
    const [user] = useState('Bruno')
    return <h1>Header {user}</h1>

}