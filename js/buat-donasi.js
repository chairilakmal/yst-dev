function handleSubmit() {
  const namaProgramDonasi = document.getElementById(
    "tb_nama_program_donasi"
  ).value;
  const nama_donatur = document.getElementById("tb_nama_donatur").value;

  var nominal1 = parseInt(
    document.querySelector('input[name="nominal1"]:checked').value
  );
  var nominal2 = parseInt(document.getElementById("nominal2").value);
  var total = parseInt(nominal1 + nominal2);

  // to set into local storage
  /* localStorage.setItem("NAME", name);
    localStorage.setItem("SURNAME", surname); */

  sessionStorage.setItem("NAMAPROGRAM", namaProgramDonasi);
  sessionStorage.setItem("NOMINAL", total);
  sessionStorage.setItem("NAMADONATUR", nama_donatur);

  return;
}
