"use client";
import React from "react";

export default function AdminLayout({ children, user = { name: "Usuário", avatarUrl: null } }) {
  return (
    <div className="min-h-screen w-full bg-base-100 text-base-content flex">
      {/* Sidebar */}
      <aside className="hidden md:flex flex-col bg-base-200 border-r border-base-300 w-72 max-w-[300px] flex-shrink-0">
        <div className="h-16 flex items-center px-4 border-b border-base-300">
          <span className="font-semibold">Admin</span>
        </div>
        <nav className="flex-1 overflow-y-auto">
          <ul className="menu p-4 w-full">
            <li><a className="active:!bg-primary/10 active:!text-primary">Dashboard</a></li>
            <li>
              <details open>
                <summary>Cadastros</summary>
                <ul>
                  <li><a>Pacientes</a></li>
                  <li><a>Profissionais</a></li>
                  <li><a>Convênios</a></li>
                </ul>
              </details>
            </li>
            <li>
              <details>
                <summary>Agenda</summary>
                <ul>
                  <li><a>Calendário</a></li>
                  <li><a>Minhas consultas</a></li>
                </ul>
              </details>
            </li>
            <li>
              <details>
                <summary>Financeiro</summary>
                <ul>
                  <li><a>Faturamento</a></li>
                  <li><a>Pagamentos</a></li>
                </ul>
              </details>
            </li>
            <li><a>Relatórios</a></li>
            <li><a>Configurações</a></li>
          </ul>
        </nav>
      </aside>

      {/* Main area */}
      <div className="flex-1 min-w-0 flex flex-col">
        {/* Header */}
        <header className="navbar bg-base-100/80 backdrop-blur border-b border-base-300 h-16 px-4">
          {/* Left: mobile menu placeholder (non-functional minimal) */}
          <div className="flex-1">
            <button className="md:hidden btn btn-ghost btn-sm">☰</button>
          </div>
          {/* Right: user */}
          <div className="flex items-center gap-3">
            <span className="text-sm opacity-80 hidden sm:inline">{user.name}</span>
            <div className="avatar">
              <div className="w-8 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                {user.avatarUrl ? (
                  // eslint-disable-next-line @next/next/no-img-element
                  <img src={user.avatarUrl} alt={user.name} />
                ) : (
                  <div className="bg-neutral text-neutral-content w-full h-full grid place-items-center text-xs">
                    {user.name?.slice(0, 2)?.toUpperCase() || "US"}
                  </div>
                )}
              </div>
            </div>
          </div>
        </header>

        {/* Content */}
        <main className="p-4 md:p-6 flex-1 overflow-auto">
          {children}
        </main>
      </div>
    </div>
  );
}
