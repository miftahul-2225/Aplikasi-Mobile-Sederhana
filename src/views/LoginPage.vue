<template>
  <ion-page>
    <ion-header>
      <ion-toolbar color="primary">
        <ion-title>Login User</ion-title>
      </ion-toolbar>
    </ion-header>

    <ion-content class="ion-padding">
      <ion-card>
        <ion-card-header>
          <ion-card-title>Silakan Login</ion-card-title>
        </ion-card-header>

        <ion-card-content>
          <!-- Input Nama -->
          <ion-item>
            <ion-input
              label="Nama"
              label-placement="floating"
              v-model="nama"
              placeholder="Masukkan nama"
            ></ion-input>
          </ion-item>

          <!-- Input Password -->
          <ion-item>
            <ion-input
              label="Password"
              label-placement="floating"
              type="password"
              v-model="password"
              placeholder="Masukkan password"
            ></ion-input>
          </ion-item>

          <!-- 🔒 Input Token Rahasia -->
          <ion-item>
            <ion-input
              label="Token Rahasia"
              label-placement="floating"
              type="password"
              v-model="token"
              placeholder="Masukkan token rahasia"
            ></ion-input>
          </ion-item>

          <!-- Tombol Login -->
          <ion-button expand="block" @click="loginUser" class="ion-margin-top">
            Login
          </ion-button>

          <!-- Pesan Error -->
          <ion-text color="danger" v-if="errorMessage">
            <p>{{ errorMessage }}</p>
          </ion-text>
        </ion-card-content>
      </ion-card>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import {
  IonPage, IonHeader, IonToolbar, IonTitle,
  IonContent, IonCard, IonCardHeader, IonCardTitle,
  IonCardContent, IonItem, IonInput, IonButton, IonText
} from "@ionic/vue";
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

const router = useRouter();
const nama = ref("");
const password = ref("");
const token = ref(""); // 🔒 Tambahkan state untuk token
const errorMessage = ref("");

const API_URL = "http://localhost/myApp/server/login.php";

const loginUser = async () => {
  if (!nama.value || !password.value || !token.value) {
    errorMessage.value = "Nama, password, dan token wajib diisi.";
    return;
  }

  try {
    const res = await axios.post(API_URL, {
      nama: nama.value,
      password: password.value,
      token: token.value, // 🔒 Kirim token ke backend
    });

    if (res.data.status === "success") {
      // Simpan data user dan token ke localStorage
      localStorage.setItem("user", JSON.stringify(res.data.user));
      localStorage.setItem("session_token", res.data.user.session_token);

      // Arahkan ke dashboard (tab4)
      router.push("/tabs/tab4");
    } else {
      errorMessage.value = res.data.message || "Login gagal, periksa kembali data Anda.";
    }
  } catch (err) {
    console.error(err);
    errorMessage.value = "Terjadi kesalahan koneksi ke server.";
  }
};
</script>
