import { NextResponse } from "next/server";

export async function GET(path, search = "") {
    // URL base
    let url = `http://127.0.0.1:8600/api/v1/${path}`;

    // Definir separador correto
    const separator = url.includes("?") ? "&" : "?";

    // Adicionar search
    url = `${url}${separator}search=${encodeURIComponent(search)}`;

    // Chamada fetch
    const res = await fetch(url);
    if (!res.ok) {
        throw new Error(`Erro ao buscar ${path}: ${res.statusText}`);
    }

    return res.json();
}