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
          <ion-item>
            <ion-input
              label="Nama"
              label-placement="floating"
              v-model="nama"
              placeholder="Masukkan nama"
            ></ion-input>
          </ion-item>

          <ion-item>
            <ion-input
              label="Password"
              label-placement="floating"
              type="password"
              v-model="password"
              placeholder="Masukkan password"
            ></ion-input>
          </ion-item>

          <ion-button expand="block" @click="loginUser" class="ion-margin-top">
            Login
          </ion-button>

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
const errorMessage = ref("");

const API_URL = "http://localhost/myApp/server/login.php"; 

const loginUser = async () => {
  if (!nama.value || !password.value) {
    errorMessage.value = "Nama dan password wajib diisi.";
    return;
  }

  try {
    const res = await axios.post(API_URL, {
      nama: nama.value,
      password: password.value,
    });

    if (res.data.status === "success") {
      // Simpan data user ke localStorage
      localStorage.setItem("user", JSON.stringify(res.data.user));

      // Arahkan ke dashboard (tab4)
      router.push("/tabs/tab4");
    } else {
      errorMessage.value = res.data.message || "Login gagal, periksa kembali nama dan password Anda.";
    }
  } catch (err) {
    console.error(err);
    errorMessage.value = "Terjadi kesalahan koneksi ke server.";
  }
};
</script>
