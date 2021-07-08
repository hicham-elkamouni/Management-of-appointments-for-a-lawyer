<template>
  <div class="container">
    <form class="form_container" @submit.prevent="signup" v-if="display">
      <div class="form_input_container">
        <label class="form_label" for="userFirstName">First Name</label>
        <input class="form_input" type="text" v-model="userFirstName" />
      </div>
      <div class="form_input_container">
        <label class="form_label" for="userLastName">Last Name</label>
        <input class="form_input" type="text" v-model="userLastName" />
      </div>
      <div class="form_input_container">
        <label class="form_label" for="userCIN">CIN</label>
        <input class="form_input" type="text" v-model="userCIN" />
      </div>
      <div class="form_input_container">
        <label class="form_label" for="userEmail">Email</label>
        <input class="form_input" type="text" v-model="userEmail" />
      </div>
      <button type="submit" class="form_button">
        Sign Up
      </button>
      <small v-if="incomplete">{{ msg }}</small>
      <span
        >Already got an account.
        <span class="swap" @click="showSign">
          Sign In.
        </span></span
      >
    </form>

    <form class="form_container" @submit.prevent="signin" v-else>
      <div class="form_input_container">
        <label class="form_label" for="Reference">Enter Your Reference</label>
        <input class="form_input" type="text" v-model="Reference" />
      </div>
      <button type="submit" class="form_button">
        check
      </button>
      <small v-if="incomplete">{{ msg }}</small>
      <span
        >Register now from
        <span class="swap" @click="showSign">
          here
        </span></span
      >
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      Reference: "",
      userFirstName: "",
      userLastName: "",
      userCIN: "",
      userEmail: "",
      display: true,
      incomplete: false,
      msg: ""
    };
  },
  methods: {
    async signup() {
      console.log(5555);
      let obj = {
        userFirstName: this.userFirstName,
        userLastName: this.userLastName,
        userCIN: this.userCIN,
        userEmail: this.userEmail
      };
      const res = await axios.post(
        "http://localhost/Management-of-appointments-for-a-lawyer/ApiUser/create",
        obj
      );

      if (res.data.state) {
        this.showSign();
        // get the generate token and put it data components ( Reference )
        this.Reference = res.data.reference;
      } else {
        this.incomplete = true;
        this.msg = res.data.message;
      }
    },
    async signin() {
      let obj = {
        Reference: this.Reference
      };

      const res = await axios.post(
        "http://localhost/Management-of-appointments-for-a-lawyer/ApiUser/checkUser",
        obj
      );

      if (res.data.status == true) {
        console.log("your reference is correct");
        console.log(res.data);
        sessionStorage.setItem("userId", res.data.userInfo.userId);
        sessionStorage.setItem(
          "userFirstName",
          res.data.userInfo.userFirstName
        );
        localStorage.setItem("ifTrue", true);

        /* console.log(res.data.reference); */
      } else {
        this.incomplete = true;
        this.msg = "check your reference again";
      }
    },
    showSign() {
      this.display = !this.display;
      this.incomplete = false;
      this.Reference = "";
      this.userFirstName = "";
      this.userLastName = "";
      this.userCIN = "";
      this.userEmail = "";
    }
  }
};
</script>

<style>
.container {
  display: flex;
  justify-content: center;
}
.form_container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  border: 1px dashed #42b983;
  border-radius: 20px;
  padding: 20px 30px;
  width: 25%;
}
.form_label {
  display: block;
  float: left;
}
.form_input_container {
  display: block;
  margin: 10px;
  width: 100%;
}
.form_input {
  width: 100%;
  padding: 10px 5px;
  margin: 5px auto;
  border: 0 none #ccc;
  border-bottom: 2px solid #42b983;
}
.form_input:focus {
  border: 2px solid #42b983;
  outline: none;
}
.form_button {
  display: block;
  padding: 10px 20px;
  background-color: #42b983;
  border: none;
  border-radius: 20px;
}

.swap {
  cursor: pointer;
  text-decoration: underline;
}
</style>
