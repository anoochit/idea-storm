# Functional #

## F1 : Category ##
  * F1.1 Category should contain the post items.
  * F1.2 Category compost of title, description.
  * F1.3 Manage the category by administrator or content manger.
  * F1.4 Each category must have syndicate (RSS or ATOM) provide lastest items (by entry) data.

## F2 : Post Item ##
  * F2.1 Each item must have category.
  * F2.2 Each item compost of title, description, created date time, name of author.
  * F2.3 Each item has score begin at 1 (first post)
  * F2.4 Each Item can plus (+1) or minut ()-1 score by another member.
  * F2.5 Only 1 score (can be +1 or -1) per member for each item.
  * F2.6 Manage the post item by administrator, content manager and the owner of each item.
  * F2.7 Each item must have syndicate (RSS or ATOM)  provide latest comment data.
  * F2.8 Member can merge item if the item is similar meaning to another items ([issue #1](https://code.google.com/p/idea-storm/issues/detail?id=#1))
  * F2.9 Item has link to another items, if the item is referred to another items ([issue #1](https://code.google.com/p/idea-storm/issues/detail?id=#1))

## F3 : Member ##
  * ~~F3.1 Visitor can sign-up as a new member of this system via OpenID service.~~
  * ~~F3.2 Member can sign-in to the system via OpenID service.~~
  * F3.3 The Avatar of each member derived from Gravatar service.
  * F3.4 Member can manage the system depend on permission rule (administrator, content manager, member and visitor)
  * ~~F3.5 The member compost of first name, last name, **email** and OpenID url.~~
  * ~~F3.6 The OpenID service 'll be the authentication system when member sign-in.~~

# Non-Functional #
  * N1.1 May be use AJAX for give a score (+1,-1).
  * ~~N1.2 Not store any user name and password, authentication from OpenID only~~.
  * ~~N1.3 Using template engine for page caching ([issue #2](https://code.google.com/p/idea-storm/issues/detail?id=#2))~~.
  * ~~N1.4 Template can be separate to each page ([issue #3](https://code.google.com/p/idea-storm/issues/detail?id=#3))~~.