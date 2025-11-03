<template>
  <ion-page>
    <ion-header>
      <ion-toolbar color="primary">
        <ion-title>Tambah User</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content class="ion-padding">
      <h2>Form Tambah User</h2>

      <form @submit.prevent="addUser">
        <!-- Nama -->
        <ion-item>
          <ion-label position="stacked">Nama</ion-label>
          <ion-input v-model="nama" required placeholder="Masukkan nama" />
        </ion-item>

        <!-- Email -->
        <ion-item>
          <ion-label position="stacked">Email</ion-label>
          <ion-input v-model="email" required type="email" placeholder="Masukkan email" />
        </ion-item>

        <!-- Password -->
        <ion-item>
          <ion-label position="stacked">Password</ion-label>
          <ion-input v-model="password" required type="password" placeholder="Masukkan password" />
        </ion-item>

        <ion-button expand="full" type="submit" color="success" class="ion-margin-top">
          Simpan
        </ion-button>
      </form>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { ref } from "vue";
import {
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonItem,
  IonLabel,
  IonInput,
  IonButton,
} from "@ionic/vue";
import axios from "axios";

// 🔹 Variabel form
const nama = ref("");
const email = ref("");
const password = ref("");

// 🔹 Fungsi tambah user
const addUser = async () => {
  if (!nama.value || !email.value || !password.value) {
    alert("Semua field wajib diisi!");
    return;
  }

  try {
    const res = await axios.post("http://localhost/myApp/server/add_user.php", {
      nama: nama.value,
      email: email.value,
      password: password.value, // kirim password ke backend
    });

    if (res.data.status === "success") {
      alert("User berhasil ditambahkan!");
      nama.value = "";
      email.value = "";
      password.value = "";
    } else {
      alert("Gagal menambahkan user: " + res.data.message);
    }
  } catch (err) {
    console.error(err);
    alert("Terjadi kesalahan saat menambahkan user.");
  }
};
</script>
