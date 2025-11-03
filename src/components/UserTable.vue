<template>
  <ion-page>
    <ion-content class="ion-padding">
      <div class="user-table-container">
        <div class="header">
          <h2>Daftar Pengguna</h2>

          <!-- 🔹 Tombol navigasi -->
          <div class="actions">
            <ion-button @click="goToAddUser" color="success">+ Tambah User</ion-button>
            <ion-button @click="goToLogin" color="primary">Login</ion-button>
          </div>
        </div>

        <!-- ✅ Tabel pengguna -->
        <table class="user-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="(user, index) in users" :key="user.id">
              <td>{{ index + 1 }}</td>
              <td>{{ user.nama }}</td>
              <td>{{ user.email }}</td>
              <td>
                <ion-button size="small" color="warning" @click="editUser(user)">Edit</ion-button>
                <ion-button size="small" color="danger" @click="deleteUser(user.id)">Hapus</ion-button>
              </td>
            </tr>

            <tr v-if="users.length === 0">
              <td colspan="4" style="text-align: center; color: gray;">
                Memuat data pengguna...
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { IonPage, IonContent, IonButton } from "@ionic/vue";

// 🧩 Definisi tipe data user
interface User {
  id: number;
  nama: string;
  email: string;
}

// 🧩 State & router
const users = ref<User[]>([]);
const router = useRouter();

// 🔹 Ambil data user dari server
const getUsers = async () => {
  try {
    const res = await axios.get("http://localhost/myApp/server/get_users.php");
    if (res.data.status === "success") {
      users.value = res.data.users;
    } else {
      alert("Gagal mengambil data user dari server!");
    }
  } catch (err) {
    console.error("Error ambil data:", err);
    alert("Tidak bisa terhubung ke server.");
  }
};

// 🔹 Fungsi tombol — Pindah ke halaman tambah user
const goToAddUser = () => {
  router.push("/input-login");
};

// 🔹 Fungsi tombol — Pindah ke halaman login
const goToLogin = () => {
  router.push("/login");
};

// 🔹 Edit user
const editUser = async (user: User) => {
  const newNama = prompt("Masukkan nama baru:", user.nama);
  const newEmail = prompt("Masukkan email baru:", user.email);
  if (!newNama || !newEmail) return;

  try {
    const res = await axios.post("http://localhost/myApp/server/update_user.php", {
      id: user.id,
      nama: newNama,
      email: newEmail,
    });

    if (res.data.status === "success") {
      alert("Data user berhasil diperbarui!");
      getUsers();
    } else {
      alert("Gagal memperbarui data user: " + res.data.message);
    }
  } catch (err) {
    console.error("Gagal update:", err);
    alert("Terjadi kesalahan saat update data!");
  }
};

// 🔹 Hapus user
const deleteUser = async (id: number) => {
  if (!confirm("Yakin ingin menghapus user ini?")) return;

  try {
    const res = await axios.post("http://localhost/myApp/server/delete_user.php", { id });
    if (res.data.status === "success") {
      alert("User berhasil dihapus!");
      getUsers();
    } else {
      alert("Gagal menghapus user!");
    }
  } catch (err) {
    console.error("Error hapus:", err);
    alert("Tidak bisa menghapus user.");
  }
};

// 🔥 Ambil data otomatis saat halaman dibuka
onMounted(() => {
  getUsers();
});
</script>

<style scoped>
.user-table-container {
  max-width: 850px;
  margin: 0 auto;
  background: #ffffff;
  padding: 16px;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

.user-table {
  width: 100%;
  border-collapse: collapse;
}

.user-table th,
.user-table td {
  border: 1px solid #dee2e6;
  padding: 10px;
  text-align: center;
}

.user-table th {
  background-color: #f8f9fa;
}
</style>
