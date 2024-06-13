// firebaseConfig.js
import { initializeApp } from "firebase/app";
import { getAuth, signInWithEmailAndPassword } from "firebase/auth";
import { getDatabase } from "firebase/database";

const firebaseConfig = {
    apiKey: "AIzaSyAda3Bw4Dr0pXmDBNHwcR4EDWlByL81M4I",
    authDomain: "speedyrepair-6f70d.firebaseapp.com",
    databaseURL: "https://speedyrepair-6f70d-default-rtdb.firebaseio.com",
    projectId: "speedyrepair-6f70d",
    storageBucket: "speedyrepair-6f70d.appspot.com",
    messagingSenderId: "93950013309",
    appId: "1:93950013309:web:c70a629b99583ae9eea614",
    measurementId: "G-T3BC6KBKTK"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getDatabase(app);

export { auth, db, signInWithEmailAndPassword };