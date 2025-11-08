// src/api.js
import axios from "axios";

const API_URL = "http://localhost/myApp/server/api.php";
const SECRET_TOKEN = "supertoken123";

// 🔹 Ambil token session user dari localStorage
function getSessionToken() {
  const user = localStorage.getItem("user");
  if (!user) return null;
  try {
    const parsed = JSON.parse(user);
    return parsed.session_token || null;
  } catch {
    return null;
  }
}

// 🔹 Buat instance axios
const api = axios.create({
  baseURL: API_URL,
});

// 🔹 Middleware: tambahkan token di setiap request
api.interceptors.request.use((config) => {
  config.headers["X-API-TOKEN"] = SECRET_TOKEN;
  const sessionToken = getSessionToken();
  if (sessionToken) {
    config.headers["Authorization"] = `Bearer ${sessionToken}`;
  }
  return config;
});

// ========================================================
// 📘 GET semua data
// ========================================================
export async function getUsers() {
  try {
    const res = await api.get("");
    return res.data;
  } catch (error) {
    console.error("❌ Error di getUsers:", error.response?.data || error.message);
    throw error;
  }
}

// ========================================================
// 📘 GET berdasarkan ID
// ========================================================
export async function getUserById(id) {
  try {
    const res = await api.get(`?id=${id}`);
    return res.data;
  } catch (error) {
    console.error("❌ Error di getUserById:", error.response?.data || error.message);
    throw error;
  }
}

// ========================================================
// 🟢 POST data baru
// ========================================================
export async function addUser(data) {
  try {
    const res = await api.post("", data);
    return res.data;
  } catch (error) {
    console.error("❌ Error di addUser:", error.response?.data || error.message);
    throw error;
  }
}

// ========================================================
// 🟡 PUT (update data)
// ========================================================
export async function updateUser(id, data) {
  try {
    const res = await api.put(`?id=${id}`, data);
    return res.data;
  } catch (error) {
    console.error("❌ Error di updateUser:", error.response?.data || error.message);
    throw error;
  }
}

// ========================================================
// 🔴 DELETE data
// ========================================================
export async function deleteUser(id) {
  try {
    const res = await api.delete(`?id=${id}`);
    return res.data;
  } catch (error) {
    console.error("❌ Error di deleteUser:", error.response?.data || error.message);
    throw error;
  }
}
