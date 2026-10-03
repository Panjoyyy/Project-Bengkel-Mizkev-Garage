---
inclusion: fileMatch
fileMatchPattern: "**/*.jsf,**/*.jspx,**/Model/**/*.java,**/ViewController/**/*.java,**/*.xml"
---

# ADF Development — Lessons Learned

Rules dan pembelajaran yang WAJIB dipatuhi saat mengerjakan project ADF ini.

## EL Expression untuk Numeric Comparison

**WAJIB:** Saat membandingkan kolom numerik dari ADF View Object dalam EL expression JSF, 
**selalu gunakan `0.0`** (Double literal), BUKAN `0` (Long literal).

- ✅ Benar: `#{row.Nilai lt 0.0 ? 'color:red;' : 'font-weight:bold;'}`
- ❌ Salah: `#{row.Nilai lt 0 ? 'color:red;' : 'font-weight:bold;'}`

**Alasan:** Kolom numerik dari VO ADF bertipe `oracle.jbo.domain.Number`. 
EL engine tidak bisa coerce tipe ini ke `java.lang.Long` (literal `0`), 
tapi bisa ke `java.lang.Double` (literal `0.0`).

**Exception yang muncul jika salah:**
```
java.lang.IllegalArgumentException: Cannot convert xxx of type class oracle.jbo.domain.Number to class java.lang.Long
```

## ADF VO Query — oracle.jbo.domain.Number

- Atribut VO yang bertipe NUMBER di database akan menjadi `oracle.jbo.domain.Number` di Java
- Saat mengambil attribute dari Row, selalu handle kemungkinan tipe ini:
  ```java
  Object oValue = row.getAttribute("SortOrder");
  if (oValue instanceof Integer) { ... }
  else if (oValue instanceof oracle.jbo.domain.Number) { ... }
  ```

## ADF JSF — Popup Design

- Hindari double scrollbar: set tinggi tetap di `af:table` di dalam popup, bukan autoHeightRows
- Gunakan `scrollPolicy="page"` + `autoHeightRows="0"` + `inlineStyle="height:XXXpx;"`
- Tinggi table = contentHeight dialog - toolbar height - spacer

## ADF JSF — Number Format Pattern

- Pattern `#,##0.00;(#,##0.00)` akan format negatif dalam kurung
- Bagian setelah `;` adalah pattern untuk nilai negatif

## Source File Encoding

- VO XML files di project ini menggunakan encoding `windows-1252`
- Jangan ubah encoding saat edit VO XML

## Code Style — If Statement

- **WAJIB** gunakan kurung kurawal `{}` untuk semua `if` statement, meskipun hanya 1 baris
- Jangan gunakan inline single-line if tanpa kurung kurawal

- ✅ Benar:
  ```java
  if (trxCode == null || trxCode.isEmpty()) {
      trxCode = defaultTrxCode;
  }
  ```
- ❌ Salah:
  ```java
  if (trxCode == null || trxCode.isEmpty()) trxCode = defaultTrxCode;
  ```


## Workflow — Delegasi Pengerjaan Kode

- **WAJIB:** Semua perubahan dan develop coding HARUS dikerjakan oleh agent (sub-agent), BUKAN langsung oleh Kiro.
- Kiro hanya boleh berdiskusi, menganalisis, dan memberikan proposal/rekomendasi.
- Saat sudah ada approval dari user untuk implementasi, Kiro WAJIB mendelegasikan pekerjaan ke agent (sub-agent) menggunakan `invoke_sub_agent`.
- Agent yang digunakan bisa `adf-code-implementor` atau `general-task-execution` tergantung kebutuhan.


## Format Task untuk KPI

Ketika user meminta "buatkan task", gunakan format berikut:

### Task
Judul singkat dan jelas tentang perubahan yang dilakukan.

### Deskripsi
Penjelasan rinci meliputi:
- Latar belakang / alasan perubahan
- Detail teknis (modul, file, function yang diubah)
- Perubahan kode (sebelum dan sesudah)
- Cara kerja perubahan tersebut
- Dampak / impact terhadap sistem

### Testing
Langkah-langkah untuk memastikan perubahan berjalan dengan benar.


## Format Task untuk KPI

Ketika user meminta "buatkan task", gunakan format berikut:

### Task
Judul singkat dan jelas tentang perubahan yang dilakukan.

### Deskripsi
Penjelasan rinci meliputi:
- Latar belakang / alasan perubahan
- Detail teknis (modul, file, function yang diubah)
- Perubahan kode (sebelum dan sesudah)
- Cara kerja perubahan tersebut
- Dampak / impact terhadap sistem

### Testing
Langkah-langkah untuk memastikan perubahan berjalan dengan benar.

### Aturan Pemecahan Task

- Jika satu fitur melibatkan beberapa perubahan berbeda (misal: penambahan filter, pembacaan config, penambahan debug), **pecah menjadi beberapa task terpisah** agar tiap task fokus pada satu perubahan.
- **EXCLUDE / JANGAN buat task** untuk perubahan yang sifatnya hanya **comment coding** (misal: meng-comment blok kode yang redundant, menghapus kode via comment). Perubahan comment-only tidak perlu dijadikan task tersendiri karena tidak mengubah behavior sistem.
- Contoh yang di-EXCLUDE: "comment ViewCriteria yang redundant", "comment baris yang tidak dipakai".
- Contoh yang TETAP dibuat task: penambahan filter/logic baru, pembacaan config baru, penambahan debug println, perubahan behavior.
