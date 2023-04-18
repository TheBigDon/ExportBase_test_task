<script>
import ImageItem from "../components/ImageItem.vue";
import { getImages } from "../services/images";
export default {
  data() {
    return {
      images: [],
    };
  },
  async mounted() {
    this.images = await getImages();
  },
  components: { ImageItem },
  methods: {
    deleteComment(id, imageId) {
      const imageIndex = this.images.findIndex((image) => image.id === imageId);
      if (imageIndex === -1) {
        return;
      }
      this.images[imageIndex] = this.images[imageIndex].comments.filter(
        (image) => {
          return image.id !== id;
        }
      );
    },
  },
};
</script>
<template>
  <div>
    <ImageItem
      v-for="image in images"
      :image="image"
      :key="image.id"
      @delete="deleteComment"
    />
  </div>
</template>
