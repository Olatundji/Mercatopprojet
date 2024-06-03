<template>
    <TheHeader></TheHeader>

    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Blog</h1>
                        <ol class="breadcrumb">
                            <li><a href="/">Home</a></li>
                            <li class="active">blog</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="products section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">

                    <div class="widget widget-latest-post">
                        <h4 class="widget-title">Latest Posts</h4>
                        <div class="media">
                            <router-link class="pull-left"  to="#">
                                <img class="media-object" src="@/assets/images/blog/post-thumb.jpg" alt="Image">
                            </router-link>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#!">Introducing Swift for Mac</a></h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, officia.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md">
                            <div v-for="(item, index) in articles" :key="index" class="post">
                                <div class="post-media post-thumb">
                                    <router-link @click="goShowArticle(item.id)"  to="/blog/single">
                                        <img :src="item.image" alt="">
                                    </router-link>
                                </div>
                                <h2 class="post-title"> <router-link @click="goShowArticle(item.id)" to="/blog/single"> {{ item.titre }} </router-link> </h2>
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
                                <div class="post-content">
                                    <p> {{ item.contenu }} </p>
                                    <router-link  @click="goShowArticle(item.id)" class="btn btn-info" to="/blog/single"> Lire plus </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <TheFooter></TheFooter>
</template>

<script>

import TheFooter from '@/components/client/TheFooter'
import TheHeader from '@/components/client/TheHeader'
import { article } from '../../../services';

export default {

    components: {
        TheFooter, TheHeader
    },
    mounted() {
        article.allArticle().then((response) => {
            console.log(response);
            this.articles = response.data
        })
    },
    data() {
        return {
            articles: []
        }
    },
    methods: {
        goShowArticle(id){
            localStorage.setItem('article_id', id)
        },
    },

}
</script>

<style lang="stylus" scoped>

</style>