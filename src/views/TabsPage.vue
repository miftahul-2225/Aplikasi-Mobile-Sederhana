<template>
  <ion-page>
    <ion-tabs>
      <ion-router-outlet></ion-router-outlet>

      <ion-tab-bar slot="bottom">
        <!-- TAB DASHBOARD -->
        <ion-tab-button tab="tab4" href="/tabs/tab4">
          <ion-icon :icon="home" />
          <ion-label>Dashboard</ion-label>
        </ion-tab-button>

        <!-- TAB USER -->
        <ion-tab-button tab="tab3" href="/tabs/tab3">
          <ion-icon :icon="person" />
          <ion-label>User</ion-label>
        </ion-tab-button>
      </ion-tab-bar>
    </ion-tabs>
  </ion-page>
</template>

<script setup lang="ts">
import {
  IonPage,
  IonTabs,
  IonRouterOutlet,
  IonTabBar,
  IonTabButton,
  IonIcon,
  IonLabel,
} from "@ionic/vue";
import { home, person } from "ionicons/icons";
</script>
