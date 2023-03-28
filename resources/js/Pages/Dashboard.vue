<template>
  <div>
    <div class="my-5">
      <h2 class="panel-title">Dashboard</h2>
    </div>
    <div id="page-wrapper mb-4">
      <div class="container mt-5 ml-5">
        <div class="row">
          <div class="col-6 my-3">
            <h3 class="panel-title">Product list</h3>
          </div>
          <div class="col-3 my-3">
            <button
              v-if="canAdd"
              @click="initProduct()"
              class="btn btn-sm btn-outline-secondary float-right"
            >
              Add New
            </button>
          </div>
          <div class="col-3 my-3">
            <button
              @click="logout()"
              class="btn btn-sm btn-outline-secondary float-right"
            >
              Logout
            </button>
          </div>
          <table class="table table-bordered table-striped">
            <tbody class="bg-secondary text-white">
              <tr>
                <th>Title</th>
                <th>Description</th>
                <th v-if="canDelete || canEdit">Action</th>
              </tr>
            </tbody>

            <tr v-for="(product, index) in products" :key="index">
              <td>
                {{ product.title }}
              </td>
              <td>
                {{ product.descr }}
              </td>

              <td v-if="canDelete || canEdit">
                <div class="row">
                  <div class="col-4">
                    <button
                      v-if="canEdit"
                      @click="initUpdate(product.id)"
                      class="btn btn-success btn-sm"
                    >
                      Edit
                    </button>
                  </div>
                  <div class="col-4 mx-2">
                    <button
                      v-if="canDelete"
                      @click="deleteproduct(index)"
                      class="btn btn-danger btn-sm mx-2"
                    >
                      Delete
                    </button>
                  </div>
                  <div class="col-4"></div>
                </div>
              </td>
            </tr>
          </table>
        </div>

        <div
          class="modal fade"
          tabindex="-1"
          role="dialog"
          id="addProductModal"
        >
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add New</h4>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="Product title"
                    class="form-control"
                    v-model="product.title"
                  />
                </div>
                <div class="form-group">
                  <textarea
                    name="description"
                    id="description"
                    cols="30"
                    rows="5"
                    class="form-control"
                    placeholder="Product Description"
                    v-model="product.descr"
                  ></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-outline-secondary btn-sm"
                  data-dismiss="modal"
                >
                  Close
                </button>
                <button
                  type="button"
                  @click="storeProduct"
                  class="btn btn-secondary btn-sm"
                >
                  Submit
                </button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div
          class="modal fade"
          tabindex="-1"
          role="dialog"
          id="updateProductModal"
        >
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Update product</h4>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <input
                    type="text"
                    placeholder="Product title"
                    class="form-control"
                    v-model="update_product.title"
                  />
                </div>
                <div class="form-group">
                  <textarea
                    cols="30"
                    rows="5"
                    class="form-control"
                    placeholder="Product Description"
                    v-model="update_product.descr"
                  ></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-outline-secondary btn-sm"
                  data-dismiss="modal"
                >
                  Close
                </button>
                <button
                  type="button"
                  @click="updateproduct"
                  class="btn btn-secondary btn-sm"
                >
                  Update
                </button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      products: [],
      product: {
        title: "",
        descr: "",
      },
      update_product: {},
      search: "",
    };
  },
  mounted() {
    this.fetchProducts();
  },

  computed: {
    canEdit() {
      let user = JSON.parse(localStorage.getItem("Test.user"));
      if (user.type == 1 || user.type == 2) return true;
    },

    canDelete() {
      let user = JSON.parse(localStorage.getItem("Test.user"));
      if (user && user.type == 1) return true;
    },

    canAdd() {
      let user = JSON.parse(localStorage.getItem("Test.user"));
      if (user && user.type == 1) return true;
    },

    canView() {
      let user = JSON.parse(localStorage.getItem("Test.user"));
      if (user.type == 1 || user.type == 2 || user.type == 3) return true;
    },
  },

  methods: {
    initProduct() {
      this.reset();
      $("#addProductModal").modal("show");
    },

    storeProduct() {
      axios
        .post("/api/products", {
          title: this.product.title,
          description: this.product.descr,
          loggedInUserId: JSON.parse(localStorage.getItem("Test.user")).id,
        })
        .then((response) => {
          $("#addProductModal").modal("hide");
          let type = {
            title: this.product.title,
            descr: this.product.descr,
          };
          this.products.push(type);
          this.reset();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    reset() {
      this.product.title = "";
      this.product.descr = "";
    },

    fetchProducts(page = 1) {
      axios.defaults.headers.common["Authorization"] =
        "Bearer " + localStorage.getItem("Test.jwt");
      axios.get("/api/products?page=" + page, {}).then((response) => {
        this.products = response.data.products;
      });
    },

    initUpdate(id) {
      $("#updateProductModal").modal("show");
      let cat = this.products.filter((category) => category.id == id);
      cat.forEach((e) => {
        this.update_product = e;
      });
    },

    updateproduct() {
      axios
        .patch("/api/products/" + this.update_product.id, {
          title: this.update_product.title,
          description: this.update_product.descr,
          loggedInUserId: JSON.parse(localStorage.getItem("Test.user")).id,
        })
        .then((response) => {
          $("#updateProductModal").modal("hide");
        })
        .catch((error) => {
          this.errors = [];
        });
    },

    deleteproduct(index) {
      axios.defaults.headers.common["Authorization"] =
        "Bearer " + localStorage.getItem("Test.jwt");
      axios
        .post("/api/products/delete", {
          loggedInUserId: JSON.parse(localStorage.getItem("Test.user")).id,
          id: this.products[index].id,
        })
        .then((response) => {
          if (response.data.response == "success") {
            this.products.splice(index, 1);
          }
        });
    },

    logout() {
      axios.defaults.headers.common["Authorization"] =
        "Bearer " + localStorage.getItem("Test.jwt");
      axios
        .get("api/logout/" + JSON.parse(localStorage.getItem("Test.user")).id)
        .then((response) => {
          this.clear_local_storage();
          delete axios.defaults.headers.common["Authorization"];
          this.$router.push("/");
        })
        .catch((error) => {
          this.clear_local_storage();
          delete axios.defaults.headers.common["Authorization"];
          this.$router.push("/");
        });
    },

    clear_local_storage() {
      localStorage.removeItem("Test.jwt");
      localStorage.removeItem("Test.user");
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
    max-width: 1200px !important;
    background-color: white;
    margin-top: 2rem;
  }
}
</style>
