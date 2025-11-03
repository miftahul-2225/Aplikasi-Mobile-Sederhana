// src/api.js
import axios from "axios";

const API_URL = "http://localhost/myApp/server/api.php";

// GET semua data
export async function getUsers() {
  const res = await axios.get(API_URL);
  return res.data;
}

// GET berdasarkan ID
export async function getUserById(id) {
  const res = await axios.get(`${API_URL}?id=${id}`);
  return res.data;
}

// POST data baru
export async function addUser(data) {
  const res = await axios.post(API_URL, data);
  return res.data;
}

// PUT (update data)
export async function updateUser(id, data) {
  const res = await axios.put(`${API_URL}?id=${id}`, data);
  return res.data;
}

// DELETE data
export async function deleteUser(id) {
  const res = await axios.delete(`${API_URL}?id=${id}`);
  return res.data;
}
