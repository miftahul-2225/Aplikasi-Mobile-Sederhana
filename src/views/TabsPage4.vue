<template>
  <ion-page>
    <ion-header>
      <ion-toolbar color="primary">
        <ion-title>Dashboard</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content class="ion-padding">
      <div class="dashboard-container">
        <h2>Selamat Datang, {{ username }}! 🎉</h2>
        <p>Anda telah berhasil login ke aplikasi.</p>

        <!-- Tombol Lihat API -->
        <ion-button color="success" expand="block" @click="fetchUsers">
          🔍 Lihat Data API
        </ion-button>

        <!-- Tampilkan data jika ada -->
        <div v-if="users.length > 0" class="api-result">
          <h3>📋 Data Pengguna dari API:</h3>
          <ul>
            <li v-for="user in users" :key="user.id">
              <strong>{{ user.nama }}</strong> — {{ user.email }}
            </li>
          </ul>
        </div>

        <!-- Jika tidak ada data -->
        <ion-text color="medium" v-else-if="isLoaded">
          <p>Tidak ada data yang ditemukan.</p>
        </ion-text>

        <!-- Tombol Logout -->
        <ion-button color="danger" expand="block" @click="logoutUser">
          Logout
        </ion-button>
      </div>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import {
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonButton,
  IonText,
} from "@ionic/vue";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { getUsers } from "@/api"; // ✅ impor fungsi API

const router = useRouter();
const username = ref("User");
const users = ref<any[]>([]);
const isLoaded = ref(false);

// 🔹 Ambil nama user dari localStorage
onMounted(() => {
  const userData = localStorage.getItem("user");
  if (userData) {
    try {
      const user = JSON.parse(userData);
      username.value = user.nama || "User";
    } catch (e) {
      console.error("Error parsing user data:", e);
    }
  } else {
    // kalau belum login, kembalikan ke halaman login
    router.push("/login");
  }
});

// 🔹 Ambil data dari API
const fetchUsers = async () => {
  try {
    const data = await getUsers();
    users.value = Array.isArray(data) ? data : [];
    isLoaded.value = true;
  } catch (err) {
    console.error("Gagal mengambil data:", err);
    alert("❌ Gagal memuat data dari API!");
    isLoaded.value = true;
  }
};

// 🔹 Fungsi Logout
const logoutUser = () => {
  localStorage.removeItem("user");
  localStorage.removeItem("session_token");
  alert("Anda telah logout!");
  router.push("/login");
};
</script>

<style scoped>
.dashboard-container {
  text-align: center;
  margin-top: 40px;
}

h2 {
  color: #007bff;
  margin-bottom: 10px;
}

p {
  color: #444;
  margin-bottom: 20px;
}

.api-result {
  margin-top: 20px;
  text-align: left;
  background: #f8f9fa;
  padding: 15px;
  border-radius: 10px;
  box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
}

.api-result ul {
  list-style: none;
  padding: 0;
}

.api-result li {
  padding: 6px 0;
  border-bottom: 1px solid #ddd;
}
</style>
