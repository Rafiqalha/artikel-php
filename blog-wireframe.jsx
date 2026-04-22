import { useState } from "react";

const SCREENS = ["Landing Page", "Article Detail", "Login / Register"];

const annotations = {
  "Landing Page": [
    { id: "nav", label: "Navbar", note: "Logo kiri · Nav links · Search icon · Tombol Login/Daftar", color: "#F59E0B" },
    { id: "hero", label: "Hero / Featured Post", note: "Gambar thumbnail besar + judul artikel utama + excerpt + tag + tombol Baca Selengkapnya", color: "#3B82F6" },
    { id: "grid", label: "Grid Artikel Terbaru", note: "3 kolom card: thumbnail · judul · tanggal · kategori · penulis", color: "#10B981" },
    { id: "sidebar", label: "Sidebar", note: "Widget: Kategori · Artikel Populer · Tag Cloud · Newsletter", color: "#8B5CF6" },
    { id: "footer", label: "Footer", note: "About · Link sosmed · Copyright", color: "#EC4899" },
  ],
  "Article Detail": [
    { id: "breadcrumb", label: "Breadcrumb", note: "Home > Kategori > Judul Artikel", color: "#F59E0B" },
    { id: "article-header", label: "Article Header", note: "Judul besar · Meta (tanggal, penulis, waktu baca) · Thumbnail full-width", color: "#3B82F6" },
    { id: "article-body", label: "Article Body", note: "Konten artikel (dari database MySQL) · heading, paragraph, image", color: "#10B981" },
    { id: "comments", label: "Komentar", note: "Form komentar (PHP POST) · list komentar dari database", color: "#8B5CF6" },
    { id: "related", label: "Artikel Terkait", note: "3 card artikel dengan kategori/tag serupa (SQL JOIN)", color: "#EC4899" },
  ],
  "Login / Register": [
    { id: "tabs", label: "Toggle Login / Daftar", note: "Tab switcher untuk berpindah form login ↔ register", color: "#F59E0B" },
    { id: "login-form", label: "Form Login", note: "Email · Password · Tombol Masuk · Lupa password?", color: "#3B82F6" },
    { id: "register-form", label: "Form Daftar", note: "Username · Email · Password · Konfirmasi Password · Daftar", color: "#10B981" },
    { id: "auth-note", label: "Backend Note", note: "PHP session_start() · password_hash() · prepared statements MySQL", color: "#8B5CF6" },
  ],
};

const WireframeLanding = ({ activeNote, setActiveNote }) => (
  <div style={{ fontFamily: "monospace", width: "100%", display: "flex", flexDirection: "column", gap: 12 }}>
    {/* Navbar */}
    <div
      onClick={() => setActiveNote(activeNote === "nav" ? null : "nav")}
      style={{
        border: `2px dashed ${activeNote === "nav" ? "#F59E0B" : "#475569"}`,
        borderRadius: 8,
        padding: "12px 20px",
        display: "flex",
        justifyContent: "space-between",
        alignItems: "center",
        cursor: "pointer",
        background: activeNote === "nav" ? "#1e1a0e" : "#0f172a",
        transition: "all 0.2s",
      }}
    >
      <div style={{ display: "flex", alignItems: "center", gap: 16 }}>
        <div style={{ width: 100, height: 22, background: "#F59E0B", borderRadius: 4, opacity: 0.8 }} />
        {["Beranda", "Kategori", "Tentang"].map(l => (
          <div key={l} style={{ width: 60, height: 12, background: "#475569", borderRadius: 3 }} />
        ))}
      </div>
      <div style={{ display: "flex", gap: 10 }}>
        <div style={{ width: 24, height: 24, border: "2px solid #475569", borderRadius: "50%" }} />
        <div style={{ width: 70, height: 28, background: "#F59E0B", borderRadius: 6, opacity: 0.9 }} />
        <div style={{ width: 70, height: 28, border: "2px solid #F59E0B", borderRadius: 6 }} />
      </div>
    </div>

    {/* Hero */}
    <div
      onClick={() => setActiveNote(activeNote === "hero" ? null : "hero")}
      style={{
        border: `2px dashed ${activeNote === "hero" ? "#3B82F6" : "#475569"}`,
        borderRadius: 8,
        padding: 20,
        cursor: "pointer",
        background: activeNote === "hero" ? "#0d1829" : "#0f172a",
        transition: "all 0.2s",
        display: "flex",
        gap: 24,
        minHeight: 160,
      }}
    >
      <div style={{ flex: 1.2, background: "#1e2a3a", borderRadius: 8, display: "flex", alignItems: "center", justifyContent: "center" }}>
        <span style={{ color: "#475569", fontSize: 12 }}>[ Thumbnail Utama ]</span>
      </div>
      <div style={{ flex: 1, display: "flex", flexDirection: "column", gap: 12, justifyContent: "center" }}>
        <div style={{ width: 80, height: 18, background: "#3B82F6", borderRadius: 12, opacity: 0.8 }} />
        <div style={{ width: "90%", height: 22, background: "#334155", borderRadius: 4 }} />
        <div style={{ width: "70%", height: 22, background: "#334155", borderRadius: 4 }} />
        <div style={{ display: "flex", flexDirection: "column", gap: 6 }}>
          {[1,2,3].map(i => <div key={i} style={{ width: "100%", height: 10, background: "#1e2a3a", borderRadius: 3 }} />)}
        </div>
        <div style={{ width: 140, height: 34, background: "#3B82F6", borderRadius: 6, opacity: 0.9 }} />
      </div>
    </div>

    {/* Main Content + Sidebar */}
    <div style={{ display: "flex", gap: 12 }}>
      {/* Article Grid */}
      <div
        onClick={() => setActiveNote(activeNote === "grid" ? null : "grid")}
        style={{
          flex: 2,
          border: `2px dashed ${activeNote === "grid" ? "#10B981" : "#475569"}`,
          borderRadius: 8,
          padding: 16,
          cursor: "pointer",
          background: activeNote === "grid" ? "#0a1f18" : "#0f172a",
          transition: "all 0.2s",
        }}
      >
        <div style={{ width: 130, height: 14, background: "#10B981", borderRadius: 4, marginBottom: 14, opacity: 0.8 }} />
        <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr 1fr", gap: 10 }}>
          {[1,2,3,4,5,6].map(i => (
            <div key={i} style={{ background: "#1e2a3a", borderRadius: 8, overflow: "hidden" }}>
              <div style={{ height: 70, background: "#263445", display: "flex", alignItems: "center", justifyContent: "center" }}>
                <span style={{ color: "#475569", fontSize: 10 }}>img</span>
              </div>
              <div style={{ padding: 8, display: "flex", flexDirection: "column", gap: 5 }}>
                <div style={{ width: "80%", height: 9, background: "#334155", borderRadius: 3 }} />
                <div style={{ width: "60%", height: 9, background: "#334155", borderRadius: 3 }} />
                <div style={{ width: "40%", height: 7, background: "#263445", borderRadius: 3 }} />
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Sidebar */}
      <div
        onClick={() => setActiveNote(activeNote === "sidebar" ? null : "sidebar")}
        style={{
          flex: 0.7,
          border: `2px dashed ${activeNote === "sidebar" ? "#8B5CF6" : "#475569"}`,
          borderRadius: 8,
          padding: 16,
          cursor: "pointer",
          background: activeNote === "sidebar" ? "#130d29" : "#0f172a",
          transition: "all 0.2s",
          display: "flex",
          flexDirection: "column",
          gap: 16,
        }}
      >
        {["Kategori", "Populer", "Tag Cloud", "Newsletter"].map(w => (
          <div key={w}>
            <div style={{ width: 80, height: 10, background: "#8B5CF6", borderRadius: 3, marginBottom: 8, opacity: 0.8 }} />
            <div style={{ display: "flex", flexDirection: "column", gap: 5 }}>
              {[1,2,3].map(i => <div key={i} style={{ width: "85%", height: 8, background: "#1e2a3a", borderRadius: 3 }} />)}
            </div>
          </div>
        ))}
      </div>
    </div>

    {/* Footer */}
    <div
      onClick={() => setActiveNote(activeNote === "footer" ? null : "footer")}
      style={{
        border: `2px dashed ${activeNote === "footer" ? "#EC4899" : "#475569"}`,
        borderRadius: 8,
        padding: 16,
        cursor: "pointer",
        background: activeNote === "footer" ? "#1a0a14" : "#0f172a",
        transition: "all 0.2s",
        display: "flex",
        justifyContent: "space-between",
        alignItems: "center",
      }}
    >
      <div style={{ width: 80, height: 16, background: "#EC4899", borderRadius: 4, opacity: 0.7 }} />
      <div style={{ display: "flex", gap: 8 }}>
        {[1,2,3].map(i => <div key={i} style={{ width: 28, height: 28, border: "2px solid #334155", borderRadius: "50%" }} />)}
      </div>
      <div style={{ width: 120, height: 10, background: "#334155", borderRadius: 3 }} />
    </div>
  </div>
);

const WireframeArticle = ({ activeNote, setActiveNote }) => (
  <div style={{ fontFamily: "monospace", width: "100%", display: "flex", flexDirection: "column", gap: 12 }}>
    {[
      { id: "breadcrumb", color: "#F59E0B", height: 36, content: (
        <div style={{ display: "flex", gap: 8, alignItems: "center", padding: "0 20px" }}>
          {["Beranda", ">", "Teknologi", ">", "Judul Artikel..."].map((t, i) => (
            <div key={i} style={{ width: i % 2 === 1 ? 10 : 70, height: 10, background: i % 2 === 1 ? "transparent" : "#475569", borderRadius: 3, color: "#475569", fontSize: 10, display: "flex", alignItems: "center" }}>{i % 2 === 1 ? "›" : null}</div>
          ))}
        </div>
      )},
      { id: "article-header", color: "#3B82F6", height: 200, content: (
        <div style={{ padding: 20, display: "flex", flexDirection: "column", gap: 12 }}>
          <div style={{ display: "flex", gap: 8 }}>
            {["PHP", "MySQL", "Tutorial"].map(t => <div key={t} style={{ padding: "2px 10px", background: "#1e3a5f", borderRadius: 12, fontSize: 10, color: "#3B82F6" }}>{t}</div>)}
          </div>
          {[1,2].map(i => <div key={i} style={{ width: i === 1 ? "85%" : "55%", height: 20, background: "#334155", borderRadius: 4 }} />)}
          <div style={{ display: "flex", gap: 16 }}>
            {["Penulis · Admin", "12 April 2025", "5 menit baca"].map(m => <div key={m} style={{ width: 100, height: 9, background: "#1e2a3a", borderRadius: 3 }} />)}
          </div>
          <div style={{ height: 80, background: "#1a2535", borderRadius: 8, display: "flex", alignItems: "center", justifyContent: "center" }}>
            <span style={{ color: "#334155", fontSize: 11 }}>[ Featured Image Full Width ]</span>
          </div>
        </div>
      )},
      { id: "article-body", color: "#10B981", height: 160, content: (
        <div style={{ padding: 20, display: "flex", flexDirection: "column", gap: 8 }}>
          <div style={{ width: "50%", height: 14, background: "#263445", borderRadius: 4 }} />
          {[1,2,3,4,5,6,7].map(i => <div key={i} style={{ width: i === 7 ? "60%" : "100%", height: 9, background: "#1e2a3a", borderRadius: 3 }} />)}
          <div style={{ width: "45%", height: 14, background: "#263445", borderRadius: 4, marginTop: 8 }} />
          {[1,2,3].map(i => <div key={i} style={{ width: "100%", height: 9, background: "#1e2a3a", borderRadius: 3 }} />)}
        </div>
      )},
      { id: "comments", color: "#8B5CF6", height: 120, content: (
        <div style={{ padding: 20 }}>
          <div style={{ width: 100, height: 12, background: "#8B5CF6", borderRadius: 4, marginBottom: 12, opacity: 0.7 }} />
          <div style={{ display: "flex", gap: 8, marginBottom: 10 }}>
            <div style={{ width: "100%", height: 60, background: "#1e2a3a", borderRadius: 6 }} />
          </div>
          <div style={{ width: 90, height: 28, background: "#8B5CF6", borderRadius: 6, opacity: 0.8 }} />
        </div>
      )},
      { id: "related", color: "#EC4899", height: 100, content: (
        <div style={{ padding: 16 }}>
          <div style={{ width: 120, height: 12, background: "#EC4899", borderRadius: 4, marginBottom: 12, opacity: 0.7 }} />
          <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr 1fr", gap: 10 }}>
            {[1,2,3].map(i => (
              <div key={i} style={{ background: "#1e2a3a", borderRadius: 8, padding: 10, display: "flex", flexDirection: "column", gap: 6 }}>
                <div style={{ height: 40, background: "#263445", borderRadius: 4 }} />
                <div style={{ width: "80%", height: 8, background: "#334155", borderRadius: 3 }} />
              </div>
            ))}
          </div>
        </div>
      )},
    ].map(({ id, color, content }) => {
      const ann = annotations["Article Detail"].find(a => a.id === id);
      return (
        <div key={id}
          onClick={() => setActiveNote(activeNote === id ? null : id)}
          style={{
            border: `2px dashed ${activeNote === id ? color : "#475569"}`,
            borderRadius: 8,
            cursor: "pointer",
            background: activeNote === id ? `${color}10` : "#0f172a",
            transition: "all 0.2s",
          }}
        >{content}</div>
      );
    })}
  </div>
);

const WireframeAuth = ({ activeNote, setActiveNote }) => {
  const [tab, setTab] = useState("login");
  return (
    <div style={{ display: "flex", flexDirection: "column", gap: 12, alignItems: "center" }}>
      {/* Tabs */}
      <div
        onClick={() => setActiveNote(activeNote === "tabs" ? null : "tabs")}
        style={{
          border: `2px dashed ${activeNote === "tabs" ? "#F59E0B" : "#475569"}`,
          borderRadius: 8, padding: 16, width: "100%", cursor: "pointer",
          background: activeNote === "tabs" ? "#1e1a0e" : "#0f172a", transition: "all 0.2s",
          display: "flex", justifyContent: "center", gap: 0,
        }}
      >
        {["login", "register"].map(t => (
          <button key={t} onClick={e => { e.stopPropagation(); setTab(t); }} style={{
            padding: "8px 32px", background: tab === t ? "#F59E0B" : "transparent",
            color: tab === t ? "#000" : "#94a3b8", border: "none", cursor: "pointer",
            borderRadius: t === "login" ? "6px 0 0 6px" : "0 6px 6px 0",
            fontWeight: tab === t ? 700 : 400, fontSize: 14, transition: "all 0.2s",
          }}>{t === "login" ? "Masuk" : "Daftar"}</button>
        ))}
      </div>

      {/* Form */}
      <div style={{ width: "100%", maxWidth: 440 }}>
        {tab === "login" ? (
          <div
            onClick={() => setActiveNote(activeNote === "login-form" ? null : "login-form")}
            style={{
              border: `2px dashed ${activeNote === "login-form" ? "#3B82F6" : "#475569"}`,
              borderRadius: 8, padding: 24, cursor: "pointer",
              background: activeNote === "login-form" ? "#0d1829" : "#0f172a", transition: "all 0.2s",
              display: "flex", flexDirection: "column", gap: 14,
            }}
          >
            {["Email", "Password"].map(f => (
              <div key={f} style={{ display: "flex", flexDirection: "column", gap: 6 }}>
                <div style={{ width: 60, height: 10, background: "#475569", borderRadius: 3 }} />
                <div style={{ height: 38, background: "#1e2a3a", borderRadius: 6, border: "1px solid #334155" }} />
              </div>
            ))}
            <div style={{ width: 100, height: 10, background: "#263445", borderRadius: 3, alignSelf: "flex-end" }} />
            <div style={{ height: 40, background: "#3B82F6", borderRadius: 6, opacity: 0.9 }} />
          </div>
        ) : (
          <div
            onClick={() => setActiveNote(activeNote === "register-form" ? null : "register-form")}
            style={{
              border: `2px dashed ${activeNote === "register-form" ? "#10B981" : "#475569"}`,
              borderRadius: 8, padding: 24, cursor: "pointer",
              background: activeNote === "register-form" ? "#0a1f18" : "#0f172a", transition: "all 0.2s",
              display: "flex", flexDirection: "column", gap: 14,
            }}
          >
            {["Username", "Email", "Password", "Konfirmasi Password"].map(f => (
              <div key={f} style={{ display: "flex", flexDirection: "column", gap: 6 }}>
                <div style={{ width: f.length * 6, height: 10, background: "#475569", borderRadius: 3 }} />
                <div style={{ height: 38, background: "#1e2a3a", borderRadius: 6, border: "1px solid #334155" }} />
              </div>
            ))}
            <div style={{ height: 40, background: "#10B981", borderRadius: 6, opacity: 0.9 }} />
          </div>
        )}
      </div>

      {/* Backend Note */}
      <div
        onClick={() => setActiveNote(activeNote === "auth-note" ? null : "auth-note")}
        style={{
          border: `2px dashed ${activeNote === "auth-note" ? "#8B5CF6" : "#475569"}`,
          borderRadius: 8, padding: 14, width: "100%", cursor: "pointer",
          background: activeNote === "auth-note" ? "#130d29" : "#0f172a", transition: "all 0.2s",
        }}
      >
        <div style={{ display: "flex", gap: 10, alignItems: "center", flexWrap: "wrap" }}>
          {["session_start()", "password_hash()", "PDO Prepared Stmt", "MySQL Users Table"].map(t => (
            <div key={t} style={{ padding: "4px 10px", background: "#1e1a3a", borderRadius: 6, color: "#8B5CF6", fontSize: 11, fontFamily: "monospace" }}>{t}</div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default function BlogWireframe() {
  const [screen, setScreen] = useState("Landing Page");
  const [activeNote, setActiveNote] = useState(null);

  const currentAnnotations = annotations[screen];
  const activeAnnotation = currentAnnotations.find(a => a.id === activeNote);

  return (
    <div style={{
      minHeight: "100vh",
      background: "#020817",
      color: "#e2e8f0",
      fontFamily: "'Courier New', monospace",
      padding: 24,
    }}>
      {/* Header */}
      <div style={{ marginBottom: 24 }}>
        <div style={{ fontSize: 11, color: "#F59E0B", letterSpacing: 3, marginBottom: 6, textTransform: "uppercase" }}>Wireframe · Blog PHP/MySQL</div>
        <h1 style={{ fontSize: 26, fontWeight: 800, margin: 0, color: "#f1f5f9", letterSpacing: -1 }}>
          Blog Landing Page
        </h1>
        <p style={{ color: "#64748b", fontSize: 12, marginTop: 6, margin: "6px 0 0" }}>
          Klik setiap komponen untuk melihat anotasi · {SCREENS.length} layar tersedia
        </p>
      </div>

      {/* Screen Tabs */}
      <div style={{ display: "flex", gap: 8, marginBottom: 20 }}>
        {SCREENS.map(s => (
          <button key={s} onClick={() => { setScreen(s); setActiveNote(null); }} style={{
            padding: "7px 18px",
            background: screen === s ? "#F59E0B" : "#0f172a",
            color: screen === s ? "#000" : "#94a3b8",
            border: `1px solid ${screen === s ? "#F59E0B" : "#334155"}`,
            borderRadius: 6,
            cursor: "pointer",
            fontSize: 12,
            fontWeight: screen === s ? 700 : 400,
            transition: "all 0.2s",
            fontFamily: "monospace",
          }}>{s}</button>
        ))}
      </div>

      <div style={{ display: "flex", gap: 20 }}>
        {/* Wireframe Canvas */}
        <div style={{ flex: 1 }}>
          {screen === "Landing Page" && <WireframeLanding activeNote={activeNote} setActiveNote={setActiveNote} />}
          {screen === "Article Detail" && <WireframeArticle activeNote={activeNote} setActiveNote={setActiveNote} />}
          {screen === "Login / Register" && <WireframeAuth activeNote={activeNote} setActiveNote={setActiveNote} />}
        </div>

        {/* Annotation Panel */}
        <div style={{ width: 240, display: "flex", flexDirection: "column", gap: 8 }}>
          <div style={{ fontSize: 10, color: "#475569", letterSpacing: 2, textTransform: "uppercase", marginBottom: 4 }}>Komponen</div>
          {currentAnnotations.map(ann => (
            <div key={ann.id}
              onClick={() => setActiveNote(activeNote === ann.id ? null : ann.id)}
              style={{
                padding: "10px 14px",
                borderRadius: 8,
                border: `1px solid ${activeNote === ann.id ? ann.color : "#1e2a3a"}`,
                background: activeNote === ann.id ? `${ann.color}15` : "#0a1220",
                cursor: "pointer",
                transition: "all 0.2s",
              }}
            >
              <div style={{ display: "flex", alignItems: "center", gap: 8 }}>
                <div style={{ width: 8, height: 8, borderRadius: "50%", background: ann.color, flexShrink: 0 }} />
                <span style={{ fontSize: 12, fontWeight: 600, color: activeNote === ann.id ? ann.color : "#cbd5e1" }}>{ann.label}</span>
              </div>
              {activeNote === ann.id && (
                <p style={{ margin: "8px 0 0 16px", fontSize: 11, color: "#94a3b8", lineHeight: 1.6 }}>{ann.note}</p>
              )}
            </div>
          ))}

          {/* Info card */}
          <div style={{
            marginTop: 12,
            padding: 14,
            background: "#0a1220",
            borderRadius: 8,
            border: "1px solid #1e2a3a",
          }}>
            <div style={{ fontSize: 10, color: "#475569", letterSpacing: 2, textTransform: "uppercase", marginBottom: 8 }}>Tech Stack</div>
            {[["Frontend", "HTML, CSS, JS"], ["Backend", "PHP (native)"], ["Database", "MySQL"], ["Auth", "PHP Session"], ["Server", "Apache/XAMPP"]].map(([k, v]) => (
              <div key={k} style={{ display: "flex", justifyContent: "space-between", marginBottom: 5 }}>
                <span style={{ fontSize: 10, color: "#475569" }}>{k}</span>
                <span style={{ fontSize: 10, color: "#10B981", fontWeight: 600 }}>{v}</span>
              </div>
            ))}
          </div>
        </div>
      </div>

      <div style={{ marginTop: 20, fontSize: 10, color: "#334155", textAlign: "center" }}>
        ✦ Klik komponen di canvas atau di panel kanan untuk toggle anotasi ✦
      </div>
    </div>
  );
}
