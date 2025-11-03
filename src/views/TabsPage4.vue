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
} from "@ionic/vue";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const username = ref("User");

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

// 🔹 Fungsi Logout
const logoutUser = () => {
  localStorage.removeItem("user");
  alert("Anda telah logout!");
  router.push("/login");
};
</script>

<style scoped>
.dashboard-container {
  text-align: center;
  margin-top: 50px;
}

h2 {
  color: #007bff;
  margin-bottom: 10px;
}

p {
  color: #444;
  margin-bottom: 30px;
}
</style>
