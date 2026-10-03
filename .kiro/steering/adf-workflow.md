---
inclusion: auto
description: "Aturan workflow ADF development - delegasi pengerjaan kode ke agent"
---

# ADF Development Workflow

## Peran Kiro (Assistant)

Kiro HANYA bertindak sebagai **asisten/koordinator**. Kiro TIDAK BOLEH:
- Menulis kode ADF langsung (JSF, Java, XML)
- Melakukan review/pengecekan kode langsung
- Memperbaiki file ADF langsung

Kiro HARUS:
- Menerima instruksi dari user
- Mendelegasikan ke agent yang tepat
- Mengkoordinasi loop antara implementor dan reviewer
- Melaporkan hasil FINAL ke user (hanya setelah reviewer sudah OK)

Kiro BOLEH kerjakan langsung:
- Dokumen non-ADF (mockup, DDL, docs, steering, hooks)
- Diskusi/konsultasi (database design, flow, requirement)

## Agent yang Tersedia

| Agent | Tugas |
|-------|-------|
| `adf-context-analyzer` | Analisis arsitektur project |
| `adf-code-implementor` | Buat kode ADF baru, perbaiki error |
| `adf-code-reviewer` | Review konsistensi, validasi kode |

## Flow Utama (WAJIB Diikuti)

```
┌─────────────────────────────────────────────────────────────────┐
│                         USER                                     │
│                    (Instruksi/Request)                           │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    KIRO (Koordinator)                            │
│  1. Terima instruksi dari user                                  │
│  2. Delegasi ke agent implementor                               │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│              AGENT: adf-code-implementor                         │
│  - Buat / perbaiki kode ADF                                     │
│  - Output: file-file yang dibuat/diubah                         │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│              AGENT: adf-code-reviewer                            │
│  - Review konsistensi JSF ↔ Bean ↔ PageDef ↔ AM                │
│  - Cek error, warning                                           │
│  - Output: laporan (PASSED / ERROR)                             │
└────────────────────────────┬────────────────────────────────────┘
                             │
                    ┌────────┴────────┐
                    │                 │
                    ▼                 ▼
            ┌─────────────┐   ┌─────────────────────────────────┐
            │  ✅ PASSED   │   │  ❌ ERROR                        │
            │             │   │                                   │
            │  Lanjut ke  │   │  1. Kembalikan ke implementor    │
            │  langkah    │   │     dengan detail error           │
            │  berikutnya │   │  2. Implementor fix               │
            └──────┬──────┘   │  3. Reviewer cek ulang            │
                   │          │  4. Loop sampai PASSED             │
                   │          └───────────────────────────────────┘
                   ▼
┌─────────────────────────────────────────────────────────────────┐
│              UPDATE LESSONS LEARNED                               │
│  - Jika fix error → tambah rule baru ke agent spec              │
│    (.kiro/agents/adf-code-implementor.md)                       │
│  - Jika buat fitur baru → skip                                  │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    KIRO (Koordinator)                            │
│  - Lapor ke user: hasil final                                   │
│  - Info: file yang dibuat/diubah                                │
│  - Info: perlu rebuild + redeploy atau tidak                    │
└─────────────────────────────────────────────────────────────────┘
```

## Aturan Loop Implementor ↔ Reviewer

1. Setelah `adf-code-implementor` selesai → WAJIB delegasi ke `adf-code-reviewer`
2. Jika reviewer menemukan ERROR → delegasi kembali ke implementor dengan detail error
3. Implementor perbaiki → reviewer cek ulang
4. **Loop sampai reviewer report PASSED** (tidak ada error)
5. Baru setelah PASSED → lapor ke user
6. JANGAN lapor ke user jika reviewer belum cek / masih ada error

## Aturan Update Lessons Learned

Setelah loop selesai (reviewer PASSED), cek:
- Apakah ada error yang diperbaiki selama loop?
- Jika YA → delegasi ke implementor untuk tambah rule baru di **KEDUA** agent spec:
  1. `.kiro/agents/adf-code-implementor.md` — di bagian "Aturan Ketelitian (Lessons Learned)"
  2. `.kiro/agents/adf-code-reviewer.md` — di bagian "Lessons Learned (Error yang pernah terjadi)"
- Rule baru harus berisi: 1) Apa yang salah, 2) Pattern yang benar, 3) Contoh kode yang benar
- Kedua agent HARUS mendapatkan informasi yang sama agar sinkron
- Jika TIDAK (hanya buat fitur baru tanpa error) → skip

## Flow per Skenario

### Skenario 1: Buat Fitur Baru

```
User instruksi
  → Kiro delegasi ke implementor
    → Implementor buat kode
      → Kiro delegasi ke reviewer
        → Reviewer cek
          → Jika ERROR → kembali ke implementor → fix → reviewer cek lagi
          → Jika PASSED → Kiro lapor ke user
```

### Skenario 2: Ada Error / Bug dari User

```
User lapor error + screenshot
  → Kiro delegasi ke implementor (sertakan error msg + file terkait)
    → Implementor fix
      → Kiro delegasi ke reviewer
        → Reviewer cek
          → Jika ERROR → kembali ke implementor → fix → reviewer cek lagi
          → Jika PASSED → Update lessons learned → Kiro lapor ke user
```

### Skenario 3: Minta Review Saja

```
User minta review
  → Kiro delegasi ke reviewer
    → Reviewer lapor temuan
      → Kiro sampaikan ke user
        → Jika user minta fix → delegasi ke implementor → reviewer cek lagi → loop
```

### Skenario 4: Analisis Project

```
User minta analisis
  → Kiro delegasi ke adf-context-analyzer
    → Analyzer hasilkan ringkasan
      → Kiro sampaikan ke user
```

## Konteks yang WAJIB Disertakan ke Agent

### Ke Implementor:
- File-file yang perlu diubah (contextFiles)
- Instruksi jelas dari user
- Error message / screenshot description (jika ada)
- Referensi docs: `.kiro/inbox-approval-case-finance/docs/`
- Agent spec: `.kiro/agents/adf-code-implementor.md` (lessons learned)

### Ke Reviewer:
- File JSF yang perlu dicek
- File Java (backing bean) yang terkait
- File PageDef yang terkait
- File AM XML + AM Impl (jika perlu cek Bean ↔ AM)
- Scope review yang spesifik (jangan kirim terlalu banyak file sekaligus)

## PENTING

- JANGAN lapor ke user sebelum reviewer bilang PASSED
- JANGAN skip step reviewer
- JANGAN fix kode sendiri (selalu via agent)
- **WAJIB update lessons learned SEBELUM lapor ke user** — jika ada error yang diperbaiki selama loop, update KEDUA agent spec DULU baru lapor hasil ke user. Ini BUKAN opsional.
- Jika agent gagal (error), retry dengan scope lebih kecil (kirim lebih sedikit file)
- Maksimum loop: 3x. Jika setelah 3x masih error, lapor ke user dengan detail semua error yang tersisa
