window.addEventListener("load", () => {
  // Via Query parameters - GET
  /* const params = (new URL(document.location)).searchParams;
    const name = params.get('name');
    const surname = params.get('surname'); */

  // Via local Storage
  /* const name = localStorage.getItem('NAME');
    const surname = localStorage.getItem('SURNAME'); */

  const namaProgramDonasi = sessionStorage.getItem("NAMAPROGRAM");
  const total = sessionStorage.getItem("NOMINAL");
  const nama_donatur = sessionStorage.getItem("NAMADONATUR");

  document.getElementById("result-name").innerHTML = namaProgramDonasi;
  document.getElementById("result-surname").innerHTML = total;
  document.getElementById("result-name2").innerHTML = nama_donatur;
});
