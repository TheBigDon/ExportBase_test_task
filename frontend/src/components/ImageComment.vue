<script>
export default {
  props: {
    comment: {
      type: Object,
      required: true,
    },
  },
  emits: ["delete"],
  methods: {
    deleteHandler() {
      this.$emit("delete", this.comment.id);
    },
  },
};
</script>

<template>
  <div class="comment">
    <div>
      <div>
        <span>{{ comment.user }}</span>
        <span>{{ comment.date_comment }}</span>
      </div>
      <p>{{ comment.text_comment }}</p>
    </div>
    <button @click="deleteHandler">Удалить</button>
  </div>
</template>

<style scoped>
.comment {
  display: flex;
  justify-content: space-between;
}
</style>
