import { BASE_URL } from "../constants";

export async function getImages() {
  const response = await fetch(BASE_URL + "images");
  return response.json();
}
