<template>
  <div class="container">
    <form class="form_container" @submit.prevent="signin">
      <div class="form_input_container">
        <label class="form_label" for="Reference">Enter Your Reference</label>
        <input class="form_input" type="text" v-model="Reference" />
      </div>
      <button type="submit" class="form_button">check</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      Reference: ""
    };
  },
  methods: {
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
        console.log("check your reference again");
      }
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
  outline: none;
}
</style>
