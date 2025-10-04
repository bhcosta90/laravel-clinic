import AdminLayout from "@/components/admin/AdminLayout";
import {Header} from "@/components/Header";

export default function Home() {
  return (
    <AdminLayout>
      <div className="grid gap-4 md:gap-6 grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <div className="card bg-base-100 border border-base-300 shadow-sm">
          <div className="card-body">
            <h2 className="card-title">Resumo</h2>
            <p>Bem-vindo ao sistema administrativo.</p>
            <div className="stats shadow">
              <div className="stat">
                <div className="stat-title">Pacientes</div>
                <div className="stat-value">128</div>
                <div className="stat-desc">+12 este mês</div>
              </div>
              <div className="stat">
                <div className="stat-title">Consultas</div>
                <div className="stat-value">42</div>
                <div className="stat-desc">Hoje</div>
              </div>
            </div>
          </div>
        </div>

        <div className="card bg-base-100 border border-base-300 shadow-sm">
          <div className="card-body">
            <h2 className="card-title">Ações rápidas</h2>
            <div className="flex flex-wrap gap-2">
              <button className="btn btn-primary btn-sm">Nova consulta</button>
              <button className="btn btn-secondary btn-sm">Novo paciente</button>
              <button className="btn btn-outline btn-sm">Relatórios</button>
            </div>
          </div>
        </div>

        <div className="card bg-base-100 border border-base-300 shadow-sm">
          <div className="card-body">
            <h2 className="card-title">Últimas atividades</h2>
            <ul className="timeline timeline-vertical">
              <li>
                <div className="timeline-start">08:30</div>
                <div className="timeline-middle">🏥</div>
                <div className="timeline-end timeline-box">Consulta marcada para João</div>
              </li>
              <li>
                <div className="timeline-start">09:10</div>
                <div className="timeline-middle">👩‍⚕️</div>
                <div className="timeline-end timeline-box">Cadastro de novo profissional</div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </AdminLayout>
  );
}
