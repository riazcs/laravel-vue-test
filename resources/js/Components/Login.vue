<template>
  <div class="container col-md-3 p-5 rounded">
    <h3 class="pb-3 font-weight-bold">Sign in</h3>
    <div class="row pt-2">
      <div class="input-group">
        <input
          type="text"
          v-model="email"
          placeholder="Email"
          class="form-control"
          required="required"
        />
      </div>
      <div class="input-group mt-3">
        <input
          type="password"
          v-model="password"
          placeholder="Password"
          class="form-control"
          required="required"
        />
      </div>
      <div class="input-group mt-3">
        <select class="form-control" v-model="type">
          <option value="">--Select user type--</option>
          <option value="1">Admin</option>
          <option value="2">Modarator</option>
          <option value="3">Client</option>
        </select>
      </div>
    </div>
    <br />
    <div class="row mt-4">
      <div>
        <button
          class="form btn-secondary hover text-center btn btn-sm mr-3"
          v-on:click="login()"
        >
          Sign In
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      email: "",
      password: "",
      showPassword: false,
      isLoading: false,
      type: "",
    };
  },
  components: {},
  mounted() {},
  methods: {
    login() {
      if (this.email.length > 0) {
        if (this.email.length > 0) {
          if (this.password.length > 0) {
            this.isLoading = true;
            let email = this.email;
            let password = this.password;
            let type = this.type;
            axios
              .post("api/login", { email, password, type })
              .then((response) => {
                if (response.data.response == "success") {
                  this.isLoading = false;
                  let user = response.data.user;
                  localStorage.setItem(
                    "Test.user",
                    JSON.stringify(response.data.user)
                  );
                  localStorage.setItem("Test.jwt", response.data.token);

                  if (
                    localStorage.getItem("Test.jwt") != null
                  ) {
                    this.$router.push("/dashboard");
                  }
                } else {
                }
              })
              .catch((error) => {
                console.log(error);
              });
          } else {
            console.log("Password must be entered");
          }
        }
      } else {
        console.log("Email must be entered and check captcha!");
      }
    },
  },
};
</script>
<style lang="scss" scoped>
$position: center;
$color: red;

@media (min-width: 1200px) {
  .container,
  .container-lg,
  .container-md,
  .container-sm,
  .container-xl {
    max-width: 400px !important;
    background-color: white;
    margin-top: 2rem;
  }
}
</style>


