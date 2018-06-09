# Predator

A fast and functional PHP Webframework.

## Design Goals

Predator is meant to be a small, lean framework for microservices in PHP. It is intended to have as few dependencies as possible, to be able to be kept in one person's head, and to be highly performant, scalable, and adhere as closely as possible to a Functional Programming Paradigm.

That doesn't mean there won't be Objects, but Object Orientation is not a serious feature. However, sometimes an object is the best way to do something, and if that is the case, then we'll use one.

1. Functional First - Everything is designed to use the Functional Programming Paradigm wherever it makes sense to do so. This means there is a greater emphasis on pure-ish functions and a distaste for mutating global state. In some cases, mutating state is necessary and desirable, but that's more rare than you think.
2. Performant - Predator should be lean and mean.
3. Unopinionated - The framework should provide the user with the minimal number of tools needed for them to define the functionality of their application. Bells, whistles, meta-programming or any of that clever nonsense is a no-go. The only exception is when we have to overcome some limitation or design flaw in PHP (less likely than you think). 
4. Not a big-idea-framework. Predator is a small-idea framework, intended to build out small microservices that need to perform like the dickens. This is not a kitchen-sink framework. Predator is more a component library than a framework.
5. Be open to contributions. We want programmers in the wild, shipping actual code, to be able to contribute with the least amount of fuss and hassle. We want to be welcoming to all, and useable by all, without exception.
6. Referntial Transparency - Every component of Predator needs to be replaceable/configurable by end users. 
7. Debug is a first class feature - many frameworks spend endless amounts of time advertising their silly features and useless generators without ever providing real world structured debugging tools. It's not just about when things go wrong, it's about when you get hired to a new project and have to take over someone elses crazy codebase and you have no idea what the hell it is even doing. The worst experience you'll have is when a project you have little to no experience with on a server you barely have access to, with a monolithic framework of abstractions blows up and everyone is running around with their hair on fire. 

## Why Predator

Because things like Laravel and Symfony are massive, slow moving, abstraction heavy megafauna. Predator is the Velociraptor hiding in the undergrowth. It shouldn't take you more than a day to get up to speed on a framework for a simple web application. Websites are not that complicated, microservices even less. Also, these monoliths are more complicated than they need to be to test and deploy. They violate the 12 Factor application six ways from sunday by implementing their own homebrewed .env (boggles the mind...boggles).

Today (2018-06-09) at work I had to install a test deployment of a symfony application. Downloading all the dependencies literally took 10 minutes. 98% of the code in those dependencies is never called. It's insane. Somebody has to do something.
