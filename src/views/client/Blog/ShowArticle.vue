<template>
    <TheHeader></TheHeader>

    <section class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="post post-single">
                        <div class="post-thumb">
                            <img class="img-responsive" :src="article.image" alt="">
                        </div>
                        <h2 class="post-title"> {{ article.titre }} </h2>
                        <div class="post-meta">
                            <ul>
                                <li>
                                    <i class="tf-ion-ios-calendar"></i> {{ article.created_at }}
                                </li>
                                <li>
                                    <i class="tf-ion-android-person"></i> POSTED BY ADMIN
                                </li>
                                <li>
                                    <a href="#!"><i class="tf-ion-chatbubbles"></i> {{ comment_count }} COMMENTS</a>
                                </li>
                            </ul>
                        </div>
                        <div class="post-content post-excerpt">
                            <p> {{ article.description }} </p>
                            <blockquote class="quote-post">
                                <p>
                                    {{ article.contenu }}
                                </p>
                            </blockquote>
                        </div>
    
                        <div class="post-comments">
                            <ul class="media-list comments-list m-bot-50 clearlist">
                                <li v-for="(item, index) in commentaires" :key="index" class="media p-3 ">
                                    <div class="media-body">
    
                                        <div class="comment-info">
                                            <div class="comment-author">
                                                <a href="#!">{{ item.user_name }}</a>
                                            </div>
                                            <time>{{ item.created_at }}</time>
                                        </div>
                                        <p> {{ item.contenu}} </p>
    
                                    </div>
                                </li>
                            </ul>
                        </div>
    
                        <div class="post-comments-form">
                            <h3 class="post-sub-heading">Laiser un commentaire </h3>
                            <form @submit.prevent="commenter" >
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <textarea v-model="contenu" name="text" id="text" class=" form-control" rows="6" placeholder="Comment" maxlength="400" required></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button v-show="isConnected"  type="submit" class="btn btn-small btn-success btn-main ">
                                            Commenter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
    
    
                    </div>
    
                </div>
            </div>
        </div>
    </section>

    <TheFooter></TheFooter>
</template>


<script>

import TheHeader from '@/components/client/TheHeader'
import TheFooter from '@/components/client/TheFooter'
import { article, commentaire } from '../../../services';
import store from '../../../store';

    export default {
        components: {
            TheHeader, TheFooter
        },
        mounted() {
            article.showArticle(localStorage.getItem('article_id')).then((response) => {
                this.article = response.data
                this.comment_count = this.article.commentaires.length
                this.commentaires = response.data.commentaires
                console.log(this.article);
            } )
        },
        data() {
            return {
                article: [],
                isConnected: store.getters.isConnect,
                contenu: '',
                comment_count: 0,
                commentaires: []
            }
        },
        methods: {
            commenter(){
                let user_id = store.getters.getUser.id
                let article_id = localStorage.getItem('article_id')
                commentaire.create(this.contenu, user_id, article_id).then((response) => {
                    if(response.status == 201){
                        location.reload()
                    }
                } )
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>