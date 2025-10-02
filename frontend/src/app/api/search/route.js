import { NextResponse } from "next/server";
import axios from "axios";

export async function GET({apiUrl, page, search, ...extraParams}) {
    // URL base
    let url = `http://127.0.0.1:8600/api/v1/${apiUrl}`;
    //
    // // Definir separador correto
    // const separator = url.includes("?") ? "&" : "?";
    //
    // // Adicionar search
    // const params = new URLSearchParams({ search, page, ...extraParams }).toString();
    //
    // url = `${url}${params}`;
    //
    // // Chamada fetch
    // const res = await fetch(url);
    // if (!res.ok) {
    //     throw new Error(`Erro ao buscar ${path}: ${res.statusText}`);
    // }

    const res = await axios.get(url, {
        params: { ...extraParams, search, page },
    })

    return res.data;
}