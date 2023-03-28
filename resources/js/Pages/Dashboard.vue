<template>
  <div>
    <div id="page-wrapper" style="padding-left: 160px">
      <div class="container mt-5 ml-5">
        <div class="row" style="margin-right: 40px; margin-left: 20px">
          <div class="col-md-12">
            <div
              class="panel panel-default mt-3"
              style="margin-left: 20px; padding: 20px 10px 60px 10px"
            >
              <div>
                <h3
                  class="panel-title"
                  style="display: inline; margin-right: 10px"
                >
                  Product list
                </h3>
                <button @click="initProduct()" class="add-new-btn">
                  Add New
                </button>
                <div class="float-right pb-3">
                  <div class="search-container float-right">
                    <input
                      type="text"
                      class="form-control"
                      v-model="search"
                      placeholder="Search product"
                    />
                    <button
                      class="float-right"
                      type="submit"
                      @click="fetchProducts"
                    >
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div>
                <span style="display: inline-block; margin: 8px 0"
                  ><b>
                    Total product: {{ products ? products.length : 0 }}</b
                  ></span
                >
              </div>
              <div class="panel-body">
                <table
                  class="table table-bordered table-striped"
                  v-if="products"
                >
                  <tbody class="bg-secondary text-white">
                    <tr>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Action</th>
                    </tr>
                  </tbody>

                  <tr v-for="(product, index) in paginatedItems" :key="index">
                    <td>
                      {{ product.title }}
                    </td>
                    <td>
                      {{ product.description }}
                    </td>
                    <td>
                      {{ product.link }}
                    </td>
                    <td>
                      {{ product.is_active == 1 ? "Active" : "Inactive" }}
                    </td>
                    <td>
                      <button v-if="canEdit"
                        @click="initUpdate(index)"
                        class="btn btn-success btn-sm"
                      >
                        <i class="fa fa-edit"></i>
                      </button>
                      <button v-if="canDelete"
                        @click="deleteproduct(index)"
                        class="btn btn-danger btn-sm"
                      >
                        <i class="fa fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
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
                  <label for="name">Title:</label>
                  <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="product Name"
                    class="form-control"
                    v-model="product.title"
                  />
                </div>
                <div class="form-group">
                  <label for="description">Description:</label>
                  <textarea
                    name="description"
                    id="description"
                    cols="30"
                    rows="5"
                    class="form-control"
                    placeholder="product Description"
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
                  <label>Title:</label>
                  <input
                    type="text"
                    placeholder="product Name"
                    class="form-control"
                    v-model="update_product.title"
                  />
                </div>
                <div class="form-group">
                  <label for="description">Description:</label>
                  <textarea
                    cols="30"
                    rows="5"
                    class="form-control"
                    placeholder="product Description"
                    v-model="update_product.description"
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
                  Submit
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
      return this.$store.getters['permissions/canEdit'];
    },
    canDelete() {
      return this.$store.getters['permissions/canDelete'];
    },
  },

  methods: {
    initProduct() {
      this.errors = [];
      this.reset();
      $("#addProductModal").modal("show");
    },

    storeProduct() {
      axios
        .post("/api/products", {
          title: this.product.title,
          description: this.product.descr,
        })
        .then((response) => {
          $("#addProductModal").modal("hide");
          let type = {
            title: this.product.title,
            description: this.product.descr,
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
        "Bearer " + localStorage.getItem("test.jwt");
      axios.get("/api/products?page=" + page, {}).then((response) => {
        this.products = response.data.products;
      });
    },

    initUpdate(index) {
      this.errors = [];
      $("#updateProductModal").modal("show");
      this.update_product = this.products.data[index];
    },

    updateproduct() {
      axios
        .patch("/api/products/" + this.update_product.id, {
          title: this.update_product.title,
          description: this.update_product.description,
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
        "Bearer " + localStorage.getItem("test.jwt");
      axios
        .delete("/api/products/" + this.products.data[index].id)
        .then((response) => {
          if (response.data.response == "success") {
            this.products.splice(index, 1);
          }
        });
    },

  },
};
</script>
<style scoped lang="scss">
.page-item.active .page-link {
  background-color: #000 !important;
  border-color: #000 !important;
}
</style>