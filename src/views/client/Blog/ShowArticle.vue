<template>
    <TheHeader></TheHeader>

    <section class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="post post-single">
                        <div class="post-thumb">
                            <img class="img-responsive" src="@/assets/images/blog/blog-post-1.jpg" alt="">
                        </div>
                        <h2 class="post-title">How To Wear Bright Shoes</h2>
                        <div class="post-meta">
                            <ul>
                                <li>
                                    <i class="tf-ion-ios-calendar"></i> 20, MAR 2017
                                </li>
                                <li>
                                    <i class="tf-ion-android-person"></i> POSTED BY ADMIN
                                </li>
                                <li>
                                    <a href="#!"><i class="tf-ion-chatbubbles"></i> 4 COMMENTS</a>
                                </li>
                            </ul>
                        </div>
                        <div class="post-content post-excerpt">
                            <p> {{ article.titre }} </p>
                            <p> {{ article.description }} </p>
                            <blockquote class="quote-post">
                                <p>
                                    {{ article.contenu }}
                                </p>
                            </blockquote>
                        </div>
    
                        <div class="post-comments">
                            <h3 class="post-sub-heading">10 Comments</h3>
                            <ul class="media-list comments-list m-bot-50 clearlist">
                                <li class="media">
    
                                    <a class="pull-left" href="#!">
                                        <img class="media-object comment-avatar" src="@/assets/images/blog/avater-1.jpg" alt="" width="50" height="50">
                                    </a>
    
                                    <div class="media-body">
    
                                        <div class="comment-info">
                                            <div class="comment-author">
                                                <a href="#!">Jonathon Andrew</a>
                                            </div>
                                            <time>July 02, 2015, at 11:34</time>
                                            <a class="comment-button" href="#!"><i class="tf-ion-chatbubbles"></i>Reply</a>
                                        </div>
    
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at magna ut ante eleifend eleifend.
                                        </p>
    
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
                console.log(response);
            } )
        },
        data() {
            return {
                article: [],
                isConnected: store.getters.isConnect,
                contenu: ''
            }
        },
        methods: {
            commenter(){
                let user_id = store.getters.getUser.id
                let article_id = localStorage.getItem('article_id')
                commentaire.create(this.contenu, user_id, article_id).then((response) => {
                    console.log(response);
                } )
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>