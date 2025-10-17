import { sortByField } from '@/helpers/listHelper'
import { itemExistsById } from '@/helpers/listHelper'
import {
  deleteAllWithApi,
  deleteWithApi,
  fetchAllFromApi,
  storeWithApi,
  updateWithApi,
} from '@/services/apiService'
import { fetchFromLocalStorage, saveInLocalStorage } from '@/services/localStorageService'
import { defineStore } from 'pinia'
import { useUserStore } from './user'
// import { ref } from 'vue';

const localCommentsKey = 'yomunity_comments'
const commentEndPoint = 'comments/'

export const useCommentsStore = defineStore('yomunityComments', {
  state: () => ({
    comments: [],
    isCommentFormClosed: true,
    currentOpenForm: '',
  }),
  getters: {
    getComments: (state) => state.comments,
  },
  actions: {
    /**
     *
     * @returns data as an array or false in case of failure
     */
    async refreshCommentsFromApi() {
      try {
        const result = await fetchAllFromApi(commentEndPoint)
        if (result[0]) {
          // console.log('Just fetched', result);
          this.comments = result[1].data
          saveInLocalStorage(localCommentsKey, this.comments)
          return result[1].data
        } else {
          return false
        }
      } catch (ex) {
        console.log(ex)
        return false
      }
    },

    /**
     * **Gets data from local storage.**
     * @returns Array or false
     */
    async refreshFromLocal() {
      let result
      try {
        result = fetchFromLocalStorage(localCommentsKey)
        if (result !== false) {
          this.comments = result
        }
        return result
      } catch (ex) {
        console.log(ex)
        return false
      }
    },

    /**
     * **Gets all comments.**
     *
     * Fetches data from api only just first load.
     * Then takes them from local storage for fast rendering
     * @returns array / false
     */
    async getAllComments() {
      let result
      result = await this.refreshCommentsFromApi()

      if (result === false) {
        result = fetchFromLocalStorage(localCommentsKey)
        if (result !== false) this.comments = result
      }
      sortByField(this.comments, (a, b) => new Date(b.created_at) - new Date(a.created_at))
      return result
    },

    /**
     * **Gets all comments of a review.**
     *
     * Fetches data from api only just first load.
     * Then takes them from local storage for fast rendering
     * @returns array / false
     */
    async getReviewComments(reviewId) {
      await this.getAllComments()
      const reviewComments = []
      for (let comment of this.comments) {
        if (comment.review === reviewId) reviewComments.push(comment)
      }
      return reviewComments
    },

    /**
     * **Gets all replies to a comment.**
     *
     * Fetches data from api only just first load.
     * Then takes them from local storage for fast rendering
     * @returns array / false
     */
    getCommentReplies(parentId) {
      return this.comments.filter((comment) => comment.parent === parentId)
    },

    /**
     * **Validates, creates, reviews to api and returns result**
     * @param {string} content
     * @param {string} reviewId
     * @param {string} userId
     * @param {string} parentId - needed in case this is a reply to another comment
     * @returns boolean
     */
    async processAndCreateComment(content, reviewId, userId, parentId = '') {
      try {
        const userStore = useUserStore()
        let newComment = {
          content,
          user_id: userStore.user.id,
          review_id: reviewId,
          parent: parentId,
        }
        const result = await storeWithApi(commentEndPoint, newComment)
        if (result[0]) {
          newComment = result[1].data[0]
          this.comments.splice(0, 0, newComment) // insert at index 0
          sortByField(this.comments, (a, b) => new Date(b.created_at) - new Date(a.created_at))
          saveInLocalStorage(localCommentsKey, this.comments)
          return true
        }
        return false
      } catch (ex) {
        console.log(ex)
        return false
      }
    },

    /**
     * **Validates and updates using api with put**
     * @param {object} theComment
     * @returns boolean
     */
    async processAndUpdateComment(theComment) {
      try {
        if (theComment && typeof theComment === 'object') {
          const resultArray = itemExistsById(theComment.id, this.comments)

          if (resultArray !== false) {
            let foundAt = resultArray[1]
            const result = await updateWithApi(commentEndPoint, theComment.id, theComment)
            if (result[0]) {
              this.comments.splice(foundAt, 1)
              this.comments.splice(0, 0, theComment) // insert at index 0
              sortByField(this.comments, (a, b) => new Date(b.created_at) - new Date(a.created_at))
              saveInLocalStorage(localCommentsKey, this.comments)
              return true
            }
          } else {
            console.log("This item doesn't exists")
          }
          return false
        } else {
          return false
        }
      } catch (ex) {
        console.log(ex)
        return false
      }
    },

    /**
     * **Deletes all comments on server**
     * @param {int} id
     * @returns boolean
     */
    async processAndDeleteComment(id) {
      try {
        if (id && id.trim() !== '' && typeof id === 'string') {
          const resultArray = itemExistsById(id, this.comments)
          if (resultArray !== false) {
            let foundAt = resultArray[1]
            const result = await deleteWithApi(commentEndPoint, id)

            if (result[0]) {
              this.comments.splice(foundAt, 1)
              saveInLocalStorage(localCommentsKey, this.comments)
              return true
            }
          } else {
            console.log("This item doesn't exists")
          }
          return false
        } else {
          return false
        }
      } catch (ex) {
        console.log(ex)
        return false
      }
    },

    /**
     * **Loops on the list of a review comments and deletes them.**
     * @returns boolean
     */
    async deleteReviewComments(reviewId) {
      return await this.useIdToDelete(commentEndPoint + 'review/', reviewId)
    },

    /**
     * **Deletes a comment replies recursively**
     * @returns boolean
     */
    async deleteCommentReplies(parent_id) {
      return await this.useIdToDelete(commentEndPoint + 'parent/', parent_id)
    },

    /**
     * **Sends a delete all request to server**
     * @returns boolean
     */
    async deleteAllComments() {
      try {
        const result = await deleteAllWithApi(commentEndPoint)

        if (result[0]) {
          this.comments = []
          saveInLocalStorage(localCommentsKey, this.comments)
          return true
        }
        return false
      } catch (ex) {
        console.log(ex)
        return false
      }
    },

    /**
     * **Deletes all comments on server**
     * @param {int} id
     * @returns boolean
     */
    async useIdToDelete(endpoint, id) {
      try {
        if (id && id.trim() !== '' && typeof id === 'string') {
          const result = await deleteWithApi(endpoint, id, 200)

          if (result[0]) {
            this.comments = result[1].data
            saveInLocalStorage(localCommentsKey, this.comments)
            return true
          }
          return false
        } else {
          return false
        }
      } catch (ex) {
        console.log(ex)
        return false
      }
    },
  },
})
