from flask import Flask, jsonify, request

app = Flask(__name__)

movies = [
    {"id": 1, "title": "Movie1", "category": "Comedy"},
    {"id": 2, "title": "Movie2", "category": "Animated"},
    {"id": 3, "title": "Movie3", "category": "Thriller"}
]
# check all movies
@app.route('/movies', methods=['GET'])
def get_movies():
    return jsonify(movies)

# get movie by id
@app.route('/movies/<int:movie_id>', methods=['GET'])
def get_movie(movie_id):
    for movie in movies:
        if movie['id'] == movie_id:
            return jsonify(movie)
    return jsonify({'Error': 'Cannot find any movie'}), 404

# Add a new movie to the jsonlist
@app.route('/movies', methods=['POST'])
def add_movie():
    new_movie = {'id': len(movies) + 1, 'title': request.json['title'], 'category': request.json['category']}
    movies.append(new_movie)
    return jsonify(new_movie)

# change/update movie 
@app.route('/movies/<int:movie_id>', methods=['PUT'])
def update_movie(movie_id):
    for movie in movies:
        if movie['id'] == movie_id:
            movie['title'] = request.json['title']
            movie['category'] = request.json['category']
            return jsonify(movie)
    return jsonify({'Error': 'Cannot find any movie'}), 404

# Delete movie 
@app.route('/movies/<int:movie_id>', methods=['DELETE'])
def delete_movie(movie_id):
    for movie in movies:
      if movie['id'] == movie_id:
          movies.remove(movie)
          return
    return jsonify({'Error': 'Cannot find any movie'}), 404


if __name__ == '__main__':
    app.run(debug=True)
