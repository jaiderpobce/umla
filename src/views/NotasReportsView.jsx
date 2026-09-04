import { FileDown, FileText, Search } from 'lucide-react';
import { useEffect, useState } from 'react';

export function NotasReportsView({ dataController, permissions }) {
  const [careers, setCareers] = useState([]);
  const [students, setStudents] = useState([]);
  const [career, setCareer] = useState('');
  const [matricula, setMatricula] = useState('');
  const [matriculaSearch, setMatriculaSearch] = useState('');
  const [report, setReport] = useState(null);
  const [loading, setLoading] = useState(true);
  const [loadingStudents, setLoadingStudents] = useState(false);
  const [error, setError] = useState('');
  const canExport = permissions.includes('export');
  const isStudent = !canExport;

  useEffect(() => {
    async function loadCareers() {
      try { const response = await dataController.getNotasReportOptions(); setCareers(response.careers || []); }
      catch (loadError) { setError(loadError.message); }
      finally { setLoading(false); }
    }
    loadCareers();
  }, [dataController]);

  async function handleCareerChange(event) {
    const nextCareer = event.target.value;
    setCareer(nextCareer); setMatricula(''); setReport(null); setStudents([]);
    if (!nextCareer) return;
    setLoadingStudents(true); setError('');
    try { const response = await dataController.getNotasReportOptions(nextCareer, isStudent ? '' : matriculaSearch); setStudents(response.students || []); }
    catch (loadError) { setError(loadError.message); }
    finally { setLoadingStudents(false); }
  }

  async function searchMatricula() {
    if (!career || !matriculaSearch.trim()) return;
    setLoadingStudents(true); setError(''); setMatricula('');
    try { const response = await dataController.getNotasReportOptions(career, matriculaSearch.trim()); setStudents(response.students || []); }
    catch (loadError) { setError(loadError.message); }
    finally { setLoadingStudents(false); }
  }

  async function handlePreview(event) {
    event.preventDefault(); setError(''); setReport(null); setLoading(true);
    try { setReport(await dataController.getNotasReportDetail(career, matricula)); }
    catch (loadError) { setError(loadError.message); }
    finally { setLoading(false); }
  }

  function openPdf() {
    const params = new URLSearchParams({ career, matricula });
    window.open(`/umla-api/api/notas/reportes/detalle/pdf?${params.toString()}`, '_blank', 'noopener,noreferrer');
  }

  return (
    <section className="notas-panel notas-reports-panel">
      <article className="info-card notas-card">
        <div className="notas-toolbar-head"><div><p className="eyebrow">Reportes académicos</p><h3>Detalle de notas</h3></div><FileText size={30} className="report-title-icon" /></div>
        <form className="notas-report-filters" onSubmit={handlePreview}>
          <label>Carrera<select value={career} onChange={handleCareerChange} disabled={loading} required><option value="">Selecciona una carrera</option>{careers.map((item) => <option key={item} value={item}>{item}</option>)}</select></label>
          {isStudent ? <label>Matrícula del alumno<select value={matricula} onChange={(event) => setMatricula(event.target.value)} disabled={!career || loadingStudents} required><option value="">{loadingStudents ? 'Cargando matrículas...' : 'Selecciona tu matrícula'}</option>{students.map((student) => <option key={student.matricula} value={student.matricula}>{student.matricula}</option>)}</select></label> : <><label>Matrícula<input value={matriculaSearch} onChange={(event) => setMatriculaSearch(event.target.value)} disabled={!career} placeholder="Ej. LA00479" /></label><button className="inline-button icon-button" type="button" onClick={searchMatricula} disabled={!career || !matriculaSearch.trim() || loadingStudents}><Search size={16} /><span>Buscar matrícula</span></button><label>Resultado<select value={matricula} onChange={(event) => setMatricula(event.target.value)} disabled={!career || loadingStudents} required><option value="">{loadingStudents ? 'Buscando...' : 'Selecciona un resultado'}</option>{students.map((student) => <option key={student.matricula} value={student.matricula}>{student.matricula} - {student.nombre}</option>)}</select></label></>}
          <button className="submit-button icon-button" type="submit" disabled={!career || !matricula || loading}><Search size={16} /><span>Previsualizar</span></button>
        </form>
        {error ? <p className="admin-message is-error">{error}</p> : null}
        {loading && !report ? <p className="empty-inline">Cargando...</p> : null}
        {report ? <div className="notas-report-preview"><div className="notas-report-preview-head"><div><p className="eyebrow">Previsualización</p><h4>{report.student.name}</h4><p>{report.student.career} · Matrícula {report.student.matricula}</p></div>{canExport ? <button className="submit-button icon-button" type="button" onClick={openPdf}><FileDown size={16} /><span>Ver PDF</span></button> : null}</div><div className="notas-report-summary"><span><strong>{report.summary.subjects}</strong> Materias</span><span><strong>{report.summary.average ?? 'N/D'}</strong> Promedio</span><span><strong>{report.summary.approved}</strong> Aprobadas</span><span><strong>{report.summary.failed}</strong> Reprobadas</span></div><div className="table-shell notas-table-shell"><table className="data-table notas-table"><thead><tr><th>Tetramestre</th><th>Periodo</th><th>Asignatura</th><th>Calificación</th><th>Catedrático</th></tr></thead><tbody>{report.rows.map((row, index) => <tr key={`${row.tetramester}-${row.subject}-${index}`}><td>{row.tetramester || 'N/D'}</td><td>{row.period || 'N/D'}</td><td>{row.subject}</td><td><span className="grade-badge">{row.grade || 'N/D'}</span></td><td>{row.teacher || 'N/D'}</td></tr>)}</tbody></table></div></div> : null}
      </article>
    </section>
  );
}
