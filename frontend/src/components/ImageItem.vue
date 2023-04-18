<script>
import ImageComment from "./ImageComment.vue";

export default {
  props: {
    image: {
      type: Object,
      required: true,
    },
  },
  components: { ImageComment },
  methods: {
    deleteHandler(id) {
      this.$emit("delete", id, this.image.id);
    },
  },
};
</script>

<template>
  <div class="post">
    <img class="post__image" :src="image.image_url" />
    <div class="post__comments">
      <ImageComment
        v-for="comment in image.comments"
        :comment="comment"
        :key="comment.id"
        @delete="deleteHandler"
      />
    </div>
  </div>
</template>

<style scoped>
.post {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
}
.post__comments {
  width: 600px;
}

.post__image {
  display: block;
}
</style>
