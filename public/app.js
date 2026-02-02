async function api(path, bodyObj) {
  const res = await fetch(path, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    // IMPORTANT: keep cookies (PHP session) working with AJAX
    credentials: "same-origin",
    body: JSON.stringify(bodyObj || {})
  });
  const data = await res.json().catch(() => ({}));
  return { ok: res.ok, status: res.status, data };
}

const $ = (id) => document.getElementById(id);

$("btnLogin").onclick = async () => {
  const r = await api("/api/login", { login: $("login").value, password: $("password").value });
  $("authStatus").textContent = JSON.stringify(r, null, 2);
};

$("btnRegister").onclick = async () => {
  const r = await api("/api/register", {
    login: $("login").value,
    password: $("password").value,
    firstName: "",
    lastName: ""
  });
  $("authStatus").textContent = JSON.stringify(r, null, 2);
};

$("btnLogout").onclick = async () => {
  const r = await api("/api/logout", {});
  $("authStatus").textContent = JSON.stringify(r, null, 2);
};

$("btnSearch").onclick = async () => {
  const r = await api("/api/contacts/search", { q: $("search").value });
  $("searchOut").textContent = JSON.stringify(r, null, 2);
};

$("btnDelete").onclick = async () => {
  const r = await api("/api/contacts/delete", 
  {
    fn: $("del-firstName").value, 
    ln: $("del-lastName").value
  });

  $("deleteOut").textContent = JSON.stringify(r, null, 2);
};

$("btnSeeAll").onclick = async () => {
  const r = await api("/api/contacts/seeall", {});
  $("seeAllOut").textContent = JSON.stringify(r, null, 2);
};

$("btnCreate").onclick = async () => {
  const r = await api("/api/contacts/create", 
  { 

    fn: $("firstName").value, 
    ln: $("lastName").value, 
    em: $("email").value,
    p: $("phone").value

  });

  $("createOut").textContent = JSON.stringify(r, null, 2);
};